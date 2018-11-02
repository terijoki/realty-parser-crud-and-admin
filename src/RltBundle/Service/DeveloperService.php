<?php

namespace RltBundle\Service;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class DeveloperService.
 */
class DeveloperService extends AbstractService
{
    public const URN = 'companies';

    /**
     * @param string $content
     *
     * @return array
     */
    protected function parseItemForLinks(string $content): array
    {
        $result = [];
        $crawler = new Crawler($content);

        foreach ($crawler->filter('li > a[class="company"]') as $li) {
            $temp = $li->getAttribute('href') ?? '';

            $id = $this->parseExtId($temp, self::URN);
            $result[$id] = $temp;
        }
        $crawler->clear();
        \ksort($result);

        return $result;
    }
}
