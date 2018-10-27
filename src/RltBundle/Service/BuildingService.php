<?php

namespace RltBundle\Service;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class BuildingService.
 */
class BuildingService extends AbstractService
{
    protected const URN = 'novostroyki';
    protected const EXPIRATION = 86400;
    private const PAGE_SIZE = 20;

    /**
     * @throws \ReflectionException
     *
     * @return array
     */
    public function parseLinks(): array
    {
        $offset = 0;
        $content = '';
        $links = [];

        while (true) {
            $param = 'o:' . $offset * static::PAGE_SIZE;
            $content = $this->request($param);
            if (empty($content)) {
                break;
            }
            $result[] = $this->parseItemForLinks($content);
            ++$offset;
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
        $temp = [];
        $result = [];
        $crawler = new Crawler($content);

        foreach ($crawler->filter('li > a[target="_blank"]') as $key => $li) {
            $temp[] = $li->getAttribute('href') ?? '';

            if (!\mb_strpos($temp[$key], '#comments')) {
                $id = $this->parseExtId($temp[$key]);
                $result[$id] = $temp[$key];
            }
        }
        $crawler->clear();
        \array_filter($result);
        \ksort($result);

        return $result;
    }

    /**
     * @param string $link
     *
     * @return int
     */
    protected function parseExtId(string $link): int
    {
        return \preg_replace('/.+\/novostroyki\/(\d+).+/ui', '$1', $link) ?? 0;
    }

    /**
     * @param string $link
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    public function getItem(string $link): string
    {
        return $this->simpleRequest($link);
    }
}
