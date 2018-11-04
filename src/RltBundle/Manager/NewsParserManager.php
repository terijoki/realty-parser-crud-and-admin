<?php

namespace RltBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Entity\Model\NewsDTO;
use RltBundle\Service\AbstractService;
use RltBundle\Service\BankService;
use RltBundle\Service\BuildingService;
use RltBundle\Service\DeveloperService;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\DomCrawler\Crawler;

final class NewsParserManager extends AbstractManager implements ParseItemInterface
{
    /**
     * @var DTOInterface
     */
    private $dto;

    /**
     * NewsParserManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param LoggerInterface        $logger
     * @param AbstractService        $service
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, ParseListInterface $service)
    {
        parent::__construct($em, $logger, $service);
        $this->dto = new NewsDTO();
    }

    /**
     * @return DTOInterface
     */
    public function getDto(): DTOInterface
    {
        return $this->dto;
    }

    /**
     * @param string $item
     * @param int    $externalId
     *
     * @return DTOInterface
     */
    public function parseItem(string $item, int $externalId): DTOInterface
    {
        $dom = new Crawler($item);

        $this->dto
            ->setName($this->parseName($dom))
            ->setTitle($this->parseTitle($dom))
            ->setDate($this->parseDate($dom))
            ->setImages($this->parseImage($dom))
            ->setText($this->parseText($dom))
            ->setRelatedEntities($this->searchRelatedEntities($dom))
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
     * @return string
     */
    private function parseDate(Crawler $dom): string
    {
        return \trim($dom->filter('div[class="date"]')->text());
    }

    /**
     * @param Crawler $dom
     *
     * @return string
     */
    private function parseTitle(Crawler $dom): string
    {
        return \trim($dom->filter('div[class="gist"]')->text());
    }

    /**
     * @param Crawler $dom
     *
     * @return string
     */
    private function parseImage(Crawler $dom): array
    {
        return [\trim($dom->filter('figure > img')->attr('src'))] ?? [];
    }

    /**
     * @param Crawler $dom
     *
     * @return string
     */
    private function parseText(Crawler $dom): string
    {
        $text = '';
        foreach ($dom->filter('div[id="news_text"] > p') as $paragraph) {
            $text .= \trim($paragraph->nodeValue) . PHP_EOL;
            $a = $paragraph->attributes;
        }

        return $text;
    }

    /**
     * @param Crawler $dom
     *
     * @return array
     */
    private function searchRelatedEntities(Crawler $dom): array
    {
        $related = [];
        foreach ($dom->filter('div[id="news_text"] > p > a') as $nodes) {
            $attr = $nodes->getAttribute('href');
            if (\mb_strpos($attr, BuildingService::SUFFIX)) {
                $related[BuildingService::SUFFIX] = $this->service->parseExtId($attr, BuildingService::SUFFIX);
            }
            if (\mb_strpos($attr, DeveloperService::SUFFIX)) {
                $related[DeveloperService::SUFFIX] = $this->service->parseExtId($attr, DeveloperService::SUFFIX);
            }
            if (\mb_strpos($attr, BankService::SUFFIX)) {
                $related[BankService::SUFFIX] = $this->service->parseExtId($attr, BankService::SUFFIX);
            }
        }

        return $related;
    }
}
