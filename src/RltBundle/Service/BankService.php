<?php

namespace RltBundle\Service;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class BankService.
 */
class BankService extends AbstractService
{
    protected const URN = 'banks';

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

            $id = $this->parseExtId($temp);
            $result[$id] = $temp;
        }
        $crawler->clear();
        \ksort($result);

        return $result;
    }
}
