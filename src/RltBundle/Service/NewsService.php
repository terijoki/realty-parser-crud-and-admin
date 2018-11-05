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
        $content = [];

        $content[] = $this->simpleRequest(static::SUFFIX . '/1');

        return $this->parseItemForLinks($content);
    }

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

            foreach ($crawler->filter('li > a') as $li) {
                $link = $li->getAttribute('href') ?? '';

                $id = $this->parseExtId($link, self::SUFFIX);
                $result[$id] = $link;
            }
            $crawler->clear();
        }
        \ksort($result);

        return $result;
    }
}
