<?php

namespace RltBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Building;
use RltBundle\Entity\Model\BuildingDTO;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Entity\Model\Flat;
use RltBundle\Service\BuildingService;
use Symfony\Component\DomCrawler\Crawler;

final class BuildingParserManager extends AbstractManager implements ParseItemInterface
{
    protected const NAME = 'banks';

    private const B_CLASS = 'Класс жилья';
    private const TYPE = 'Тип здания';
    private const FLOORS = 'Этажность';
    private const FLATS = 'Квартир';
    private const PARKING = 'Паркинг';
    private const FACING = 'Отделка:';
    private const PERMISSION = 'Разрешение на строительство';
    private const PAYMENT = 'Оплата';
    private const CONTRACT = 'Договор';
    private const DEVELOPER = 'Застройщик:';
    private const ACCREDITATION = 'Аккредитация';
    private const UPDATED = 'Обновлено';
    private const DATE_FINISH = 'Дата сдачи';

    private const FLAT_SIZE = 0;
    private const COST_PER_M2 = 8;
    private const TOTAL_COST = 10;
    private const IMAGE = 12;
    private const FLAT_BUILD_DATE = 14;

    private const FLAT_SIZE_S = 0;
    private const COST_PER_M2_S = 6;
    private const TOTAL_COST_S = 9;
    private const IMAGE_S = 10;
    private const FLAT_BUILD_DATE_S = 12;

    private const STANDART_COLUMN_COUNT = 16;
    private const STUDIO = 'S';

    /**
     * @var DTOInterface
     */
    private $dto;

    /**
     * BuildingParserManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param LoggerInterface        $logger
     * @param BuildingService        $service
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, BuildingService $service)
    {
        parent::__construct($em, $logger, $service);
        $this->dto = new BuildingDTO();
    }

    /**
     * @return BuildingDTO
     */
    public function getDto(): BuildingDTO
    {
        return $this->dto;
    }

    /**
     * @param string $item
     * @param int    $externalId
     *
     * @throws \ReflectionException
     *
     * @return DTOInterface
     */
    public function parseItem(string $item, int $externalId): DTOInterface
    {
        $dom = new Crawler($item);
        $this->externalId = $externalId;

        $this->parseCharacteristics($dom);
        $this->parseFlats($dom);
        $this->dto
            ->setName($this->parseName($dom))
            ->setMetro($this->parseMetro($dom))
            ->setAddress($this->parseAddress($dom))
            ->setImages($this->parseImages($dom))
            ->setDescription($this->parseDescription($dom))
            ->setOurOpinition($this->parseOurOpinition($dom))
            ->setPrice($this->parsePrice($dom))
            ->setPricePerM2($this->parsePricePerM2($dom))
        ;

        $dom->clear();

        return $this->getDto();
    }

    /**
     * @param Crawler $dom
     *
     * @return string
     */
    private function parseName(Crawler $dom): string
    {
        try {
            return $dom->filter('h1[itemprop="name"]')->text();
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), [
                'category' => 'no-name',
                'info' => $dom->html(),
            ]);
        }
    }

    /**
     * @param Crawler $dom
     *
     * @return null|string
     */
    private function parseMetro(Crawler $dom): ?string
    {
        return \trim($dom->filter('div[class="build-info-metro"] > a')->text());
    }

    /**
     * @param Crawler $dom
     */
    private function parseCharacteristics(Crawler $dom): void
    {
        foreach ($dom->filter('table[class="build-info-data"]')->eq(0)->children() as $node) {
            $result = \trim($node->childNodes->item(2)->nodeValue);

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
                    $this->dto->setParking($result);

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
            $result = \trim($node->childNodes->item(2)->nodeValue);
            switch ($node->childNodes->item(1)->nodeValue) {
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
                    $this->dto->setAccreditation($this->parseBanks($node));
                    $this->dto->setBankLinks($this->parseBankLinks($node));

                    break;
                case self::UPDATED:
                    $this->dto->setUpdated($result);

                    break;
            }
        }

        $this->dto->setBuildDate($this
                                ->parseBuildDate($dom
                                ->filter('table[class="build-info-data build-info-queue"]')
                                ->eq(0)
                                ->children()
                                ->getNode(0)
                                ->childNodes));
    }

    /**
     * @param \DOMNodeList $node
     *
     * @return array
     */
    private function parseBuildDate(\DOMNodeList $node): array
    {
        $dates = [];
        if (self::DATE_FINISH === $node->item(0)->nodeValue) {
            foreach ($node->item(2)->getElementsByTagName('span') as $item) {
                $result = \trim($item->firstChild->nodeValue);
                if (\mb_stripos(\mb_strtolower($result), 'сдано')) {
                    $this->dto->setStatus(true);
                }
                $dates[] = $result;
            }
        }

        return $dates;
    }

    /**
     * @param \DOMElement $node
     *
     * @return string
     */
    private function parseDeveloper(\DOMElement $node): string
    {
        return $node->getElementsByTagName('a')->item(0)->nodeValue;
    }

    /**
     * @param \DOMElement $node
     *
     * @return string
     */
    private function parseDeveloperLink(\DOMElement $node): string
    {
        return $node->getElementsByTagName('a')->item(0)->getAttribute('href');
    }

    /**
     * @param \DOMElement $nodes
     *
     * @return array
     */
    private function parseBanks(\DOMElement $nodes): array
    {
        $banks = [];

        foreach ($nodes->getElementsByTagName('a') as $key => $node) {
            $banks[] = $node->nodeValue;
            if (\preg_match('/еще/u', $banks[$key], $matches)) {
                unset($banks[$key]);
            }
        }

        return $banks;
    }

    /**
     * @param \DOMElement $nodes
     *
     * @return array
     */
    private function parseBankLinks(\DOMElement $nodes): array
    {
        $bankLinks = [];

        foreach ($nodes->getElementsByTagName('a') as $key => $node) {
            $bankLinks[] = $node->getAttribute('href');
            if (\preg_match('/#/u', $bankLinks[$key], $matches)) {
                unset($bankLinks[$key]);
            }
        }

        return $bankLinks;
    }

    /**
     * @param Crawler $dom
     *
     * @return null|string
     */
    private function parseAddress(Crawler $dom): ?string
    {
        return \trim($dom->filter('div[class="build-info-address"] > a')->text());
    }

    /**
     * @param Crawler $dom
     *
     * @return null|array
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
     *
     * @return null|string
     */
    private function parseDescription(Crawler $dom): ?string
    {
        return \trim($dom->filter('div[itemprop="description"]')->html());
    }

    /**
     * @param Crawler $dom
     *
     * @return null|string
     */
    private function parseOurOpinition(Crawler $dom): ?string
    {
        return \trim($dom->filter('div[class="p_c"]')->text());
    }

    /**
     * @param Crawler $dom
     *
     * @return null|string
     */
    private function parsePrice(Crawler $dom): ?string
    {
        $node = $dom->filter('div[class="build-info-price"] > p')->getNode(0);

        return \trim($node->firstChild->nodeValue);
    }

    /**
     * @param Crawler $dom
     *
     * @return null|string
     */
    private function parsePricePerM2(Crawler $dom): ?string
    {
        $node = $dom->filter('div[class="build-info-price"] > p')->getNode(1);

        return \trim($node->firstChild->nodeValue);
    }

    /**
     * @param Crawler $dom
     *
     * @throws \ReflectionException
     */
    private function parseFlats(Crawler $dom): void
    {
        for ($rooms = 0; $rooms < 6; ++$rooms) {
            if (0 === $rooms) {
                $selector = 'div[data-type=' . self::STUDIO . ']';
            } else {
                $selector = 'div[data-type="' . $rooms . '"]';
            }
            foreach ($dom->filter($selector)->filter('tr[itemprop="offers"]') as $flat) {
                if (self::STANDART_COLUMN_COUNT === $flat->childNodes->count()) {
                    $params = [
                        'flat_size' => self::FLAT_SIZE,
                        'cost_per_m2' => self::COST_PER_M2,
                        'total_cost' => self::TOTAL_COST,
                        'plan_image' => self::IMAGE,
                        'build_date' => self::FLAT_BUILD_DATE,
                    ];
                } else {
                    $params = [
                        'flat_size' => self::FLAT_SIZE_S,
                        'cost_per_m2' => self::COST_PER_M2_S,
                        'total_cost' => self::TOTAL_COST_S,
                        'plan_image' => self::IMAGE_S,
                        'build_date' => self::FLAT_BUILD_DATE_S,
                    ];
                }
                $this->createFlat($flat, $rooms, $params);
            }
        }
    }

    /**
     * @param \DOMElement $item
     * @param int         $rooms
     * @param array       $params
     *
     * @throws \ReflectionException
     */
    private function createFlat(\DOMElement $item, int $rooms, array $params): void
    {
        $flat = new Flat();

        $flat->setRooms($rooms);
        foreach ($item->childNodes as $key => $field) {
            switch ($key) {
                case $params['flat_size']:
                    $flat->setSize(\trim($field->nodeValue));

                    break;
                case $params['cost_per_m2']:
                    $flat->setCostPerM2(\trim($field->nodeValue));

                    break;
                case $params['total_cost']:
                    $flat->setCost(\trim($field->nodeValue));

                    break;
                case $params['plan_image']:
//                    $imagePath = $this->uploadImage($field->getElementsByTagName('a')->item(0)->getAttribute('href'), $this->externalId);
//                    $flat->setImg($imagePath);

                    break;
                case $params['build_date']:
                    $flat->setBuildDate(\trim($field->nodeValue));

                    break;
            }
        }
        $this->dto->addFlat($flat);
    }

    /**
     * @param string $item
     * @param int    $id
     *
     * @return bool
     */
    public function needToUpdate(string $item, int $id): bool
    {
        $dom = new Crawler(\file_get_contents(__DIR__ . '/../../../var/mock/building1.html'));

        foreach ($dom->filter('table[class="build-info-data"]')->eq(1)->children() as $node) {
            if (self::UPDATED === $node->firstChild->nodeValue) {
                $lastUpdated = $this->convertToDatetime(\trim($node->childNodes->item(2)->nodeValue));
                /** @var Building $building */
                $building = $this->findByExternalId(Building::class, $id);
                if ($lastUpdated > $building->getExternalUpdated()) {
                    return true;
                }
            }
        }

        return false;
    }
}
