<?php

namespace RltBundle\Service;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class BankService.
 */
class BankService extends AbstractService
{
    public const SUFFIX = 'banks';

    /**
     * @param array $content
     *
     * @return array
     */
    protected function parseItemForLinks(array $content): array
    {
        $result = [];
        foreach ($content as $item) {
            $crawler = new Crawler($item);

            foreach ($crawler->filter('li > a[class="company"]') as $li) {
                $temp = $li->getAttribute('href') ?? '';

                $id = $this->parseExtId($temp, self::SUFFIX);
                $result[$id] = $temp;
            }
            $crawler->clear();
        }
        \ksort($result);

        return $result;
    }
}
