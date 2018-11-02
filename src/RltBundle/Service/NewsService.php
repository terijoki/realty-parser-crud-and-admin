<?php

namespace RltBundle\Service;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class NewsService.
 */
class NewsService extends AbstractService
{
    public const URN = 'news';

    /**
     * @throws \ReflectionException
     *
     * @return array
     */
    public function parseLinks(): array
    {
        $links = [];

        while (true) {
            $page = 1;
            $content = $this->simpleRequest(static::URN . '/' . $page);
            if (empty($content)) {
                break;
            }
            $links[] = $this->parseItemForLinks($content);
            $content = '';
            ++$page;
            \sleep(self::DELAY);
        }

        return \array_merge(...$links);
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

            $id = $this->parseExtId($link, self::URN);
            $result[$id] = $link;
        }
        $crawler->clear();
        \ksort($result);

        return $result;
    }
}
