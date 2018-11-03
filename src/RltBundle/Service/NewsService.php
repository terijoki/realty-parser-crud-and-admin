<?php

namespace RltBundle\Service;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class NewsService.
 */
class NewsService extends AbstractService
{
    public const SUFFIX = 'news';

    /**
     * For news list there is no need to crawl all the links
     * every time, just the last 30 notes are enough.
     *
     * @throws \ReflectionException
     *
     * @return array
     */
    public function parseLinks(): array
    {
        $links = [];

        $content = $this->simpleRequest(static::SUFFIX . '/1');

        $links[] = $this->parseItemForLinks($content);

        return $links;
    }

    /**
     * @param string $content
     *
     * @return array
     */
    protected function parseItemForLinks(string $content): array
    {
        $result = [];
        $crawler = new Crawler($content);

        foreach ($crawler->filter('li > a') as $li) {
            $link = $li->getAttribute('href') ?? '';

            $id = $this->parseExtId($link, self::SUFFIX);
            $result[$id] = $link;
        }
        $crawler->clear();
        \ksort($result);

        return $result;
    }
}
