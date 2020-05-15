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
     * @param string $selector
     *
     * @return array
     */
    public function parseLinks(string $selector): array
    {
        $content = [];

        $content[] = $this->simpleRequest(static::SUFFIX . '/1');

        return $this->parseItemForLinks($content, $selector);
    }
}
