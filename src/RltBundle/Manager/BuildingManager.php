<?php
/**
 * Created by PhpStorm.
 * User: vladimir
 * Date: 25.10.18
 * Time: 12:25
 */

namespace RltBundle\Manager;


use RltBundle\Entity\Model\BuildingDTO;
use Symfony\Component\DomCrawler\Crawler;

class BuildingManager extends AbstractManager
{
    protected const B_CLASS = 'Класс жилья';
    protected const TYPE = 'Тип здания';
    protected const FLOORS = 'Этажность';
    protected const FLATS = 'Квартир';
    protected const PARKING = 'Паркинг';
    protected const FACING = 'Отделка:';
    protected const PERMISSION = 'Разрешение на строительство';
    protected const PAYMENT = 'Оплата';
    protected const CONTRACT = 'Договор';
    protected const DEVELOPER = 'Застройщик:';
    protected const ACCREDITATION = 'Аккредитация';
    protected const UPDATED = 'Обновлено';
    protected const DATE_FINISH = 'Дата сдачи';

    protected const FLAT_SIZE = 0;
    protected const COST_PER_M2 = 8;
    protected const TOTAL_COST = 10;
    protected const IMAGE = 12;
    protected const FLAT_BUILD_DATE = 14;

    protected const STANDART_COLUMN_COUNT = 16;
    protected const STUDIO = 'S';

    /**
     * @var BuildingDTO
     */
    private $dto;

    /**
     * @param string $item
     * @param string $link
     * @return BuildingDTO
     */
    public function createBuilding(string $item, string $link)
    {
        $dom = new Crawler(file_get_contents(__DIR__ .'/'. 'item.html'));

        $this->dto = new BuildingDTO();
        $this->parseCharacteristics($dom);
        $this->parseFlats($dom);
        $this->dto
            ->setName($this->parseName($dom, $link))
            ->setMetro($this->parseMetro($dom))
            ->setAddress($this->parseAddress($dom))
            ->setImages($this->parseImages($dom))
            ->setDescription($this->parseDescription($dom))
            ->setOurOpinition($this->parseOurOpinition($dom))
            ->setPrice($this->parsePrice($dom))
            ->setPricePerM2($this->parsePricePerM2($dom))
        ;
        $dom->clear();

        return $this->dto;
    }

    /**
     * @param Crawler $dom
     * @param string $link
     * @return string
     */
    private function parseName(Crawler $dom, string $link): string
    {
        try {
            return $dom->filter('h1[itemprop="name"]')->text();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), [
                'category' => 'no-name',
                'link_info' => $link,
            ]);
        }
    }

    /**
     * @param Crawler $dom
     * @return null|string
     */
    private function parseMetro(Crawler $dom): ?string
    {
        return trim($dom->filter('div[class="build-info-metro"] > a')->text());
    }

    /**
     * @param Crawler $dom
     */
    private function parseCharacteristics(Crawler $dom): void
    {
        foreach ($dom->filter('table[class="build-info-data"]')->eq(0)->children() as $node) {
            $result = trim($node->childNodes->item(2)->nodeValue);
            switch ($node->firstChild->nodeValue) {
                case self::B_CLASS:
                    $this->dto->setClass($result);
                    break;
                case self::TYPE:
                    $this->dto->setBuildType($result);
                    break;
                case self::FLOORS:
                    $this->dto->setFloors($result);
                    break;
                case self::FLATS:
                    $this->dto->setFlatCount($result);
                    break;
                case self::PARKING:
                    $this->dto->setFloors($result);
                    break;
                case self::FACING:
                    $this->dto->setFacing($result);
                    break;
                case self::PERMISSION:
                    $this->dto->setPermission($result);
                    break;
            }
        }

        foreach ($dom->filter('table[class="build-info-data"]')->eq(1)->children() as $node) {
            $result = trim($node->childNodes->item(2)->nodeValue);
            switch ($node->firstChild->nodeValue) {
                case self::PAYMENT:
                    $this->dto->setPaymentType($result);
                    break;
                case self::CONTRACT:
                    $this->dto->setContractType($result);
                    break;
                case self::DEVELOPER:
                    $this->dto->setDeveloper($this->parseDeveloper($node));
                    $this->dto->setDeveloperLink($this->parseDeveloperLink($node));
                    break;
                case self::ACCREDITATION:
                    $this->dto->setBanks($this->parseBanks($node));
                    $this->dto->setBankLinks($this->parseBankLinks($node));
                    break;
                case self::UPDATED:
                    $this->dto->setUpdated($result);
                    break;
            }
        }

        $this->dto->setBuildDate($this->parseBuildDate($dom
                                ->filter('table[class="build-info-data build-info-queue"]')
                                ->eq(0)
                                ->children()
                                ->getNode(0)
                                ->childNodes));
    }

    /**
     * @param \DOMNodeList $node
     * @return array|null
     */
    private function parseBuildDate(\DOMNodeList $node): ?array
    {
        $dates = [];
        if ($node->item(0)->nodeValue === self::DATE_FINISH) {
            foreach ($node->item(2)->getElementsByTagName('span') as $item) {
                $dates[] = trim($item->firstChild->nodeValue);
            }
        }
        return $dates;
    }

    /**
     * @param \DOMElement $node
     * @return string
     */
    private function parseDeveloper(\DOMElement $node)
    {
        return $node->getElementsByTagName('a')->item(0)->nodeValue;
    }

    /**
     * @param \DOMElement $node
     * @return string
     */
    private function parseDeveloperLink(\DOMElement $node)
    {
        return $node->getElementsByTagName('a')->item(0)->getAttribute('href');
    }

    /**
     * @param \DOMElement $nodes
     * @return array
     */
    private function parseBanks(\DOMElement $nodes)
    {
        $banks = [];

        foreach ($nodes->getElementsByTagName('a') as $key => $node) {
            $banks[] = $node->nodeValue;
            if (preg_match('/еще/u', $banks[$key], $matches)) {
                unset($banks[$key]);
            }
        }
        return $banks;
    }

    /**
     * @param \DOMElement $nodes
     * @return array
     */
    private function parseBankLinks(\DOMElement $nodes)
    {
        $bankLinks = [];

        foreach ($nodes->getElementsByTagName('a') as $key => $node) {
            $bankLinks[] = $node->getAttribute('href');
            if (preg_match('/#/u', $bankLinks[$key], $matches)) {
                unset($bankLinks[$key]);
            }
        }

        return $bankLinks;
    }

    /**
     * @param Crawler $dom
     * @return null|string
     */
    private function parseAddress(Crawler $dom): ?string
    {
        return trim($dom->filter('div[class="build-info-address"] > a')->text());
    }

    /**
     * @param Crawler $dom
     * @return array|null
     */
    private function parseImages(Crawler $dom): ?array
    {
        $images = [];

        foreach ($dom->filter('div[class="slider_cnt"] > ul > li > img') as $img) {
            $images[] = $img->getAttribute('src');
        }
        return $images;
    }

    /**
     * @param Crawler $dom
     * @return null|string
     */
    private function parseDescription(Crawler $dom): ?string
    {
        return trim($dom->filter('div[itemprop="description"]')->text());
    }

    /**
     * @param Crawler $dom
     * @return null|string
     */
    private function parseOurOpinition(Crawler $dom): ?string
    {
        return trim($dom->filter('div[class="p_c"]')->text());
    }

    /**
     * @param Crawler $dom
     * @return null|string
     */
    private function parsePrice(Crawler $dom): ?string
    {
        $node = $dom->filter('div[class="build-info-price"] > p')->getNode(0);
        return trim($node->firstChild->nodeValue);
    }

    /**
     * @param Crawler $dom
     * @return null|string
     */
    private function parsePricePerM2(Crawler $dom): ?string
    {
        $node = $dom->filter('div[class="build-info-price"] > p')->getNode(1);
        return trim($node->firstChild->nodeValue);
    }

    /**
     * @param Crawler $dom
     */
    private function parseFlats(Crawler $dom): void
    {
        for ($rooms = 0; $rooms < 6; ++$rooms) {
            if ($rooms === 0) {
                $selector = 'div[data-type="S"]';
            } else {
                $selector = 'div[data-type="'. $rooms .'"]';
            }
            foreach ($dom->filter($selector)->filter('tr[itemprop="offers"]') as $flat) {
                if ($flat->childNodes->count() === self::STANDART_COLUMN_COUNT) {
                    $params = [
                        'flat_size' => self::FLAT_SIZE,
                        'cost_per_m2' => self::COST_PER_M2,
                        'total_cost' => self::TOTAL_COST,
                        'plan_image' => self::IMAGE,
                        'build_date' => self::FLAT_BUILD_DATE
                    ];
                    $this->createFlat($flat, $params);
                } else {
                    $params = [
                        //todo: change
                        'flat_size' => self::FLAT_SIZE,
                        'cost_per_m2' => self::COST_PER_M2,
                        'total_cost' => self::TOTAL_COST,
                        'plan_image' => self::IMAGE,
                        'build_date' => self::FLAT_BUILD_DATE
                    ];
                    $this->createFlat($flat, $params);
                }
            }

        }
    }

    /**
     * @param \DOMElement $flat
     * @param array $params
     */
    private function createFlat(\DOMElement $flat, array $params): void
    {
        foreach ($flat->childNodes as $key => $field) {
            switch ($key) {
                case $params['flat_size']:
                    $this->dto->setFlatSize(trim($field->nodeValue));
                    break;
                case $params['cost_per_m2']:
                    $this->dto->setFlatCostPerM2(trim($field->nodeValue));
                    break;
                case $params['total_cost']:
                    $this->dto->setFlatCost(trim($field->nodeValue));
                    break;
                case $params['plan_image']:
                    $this->dto->setFlatImg($field->getElementsByTagName('a')->item(0)->getAttribute('href'));
                    break;
                case $params['build_date']:
                    $this->dto->setFlatBuildDate(trim($field->nodeValue));
                    break;
            }
        }
    }
}