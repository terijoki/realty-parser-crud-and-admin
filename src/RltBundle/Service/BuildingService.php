<?php

namespace RltBundle\Service;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class BuildingService.
 */
class BuildingService extends AbstractService
{
    public const SUFFIX = 'novostroyki';

    /**
     * @param string $content
     *
     * @return array
     */
    protected function parseItemForLinks(string $content): array
    {
        $result = [];
        $crawler = new Crawler($content);

        foreach ($crawler->filter('li > a[class="n"]') as $li) {
            $temp = $li->getAttribute('href') ?? '';

            $id = $this->parseExtId($temp, self::SUFFIX);
            $result[$id] = $temp;
        }
        $crawler->clear();
        \ksort($result);

        return $result;
    }
}
