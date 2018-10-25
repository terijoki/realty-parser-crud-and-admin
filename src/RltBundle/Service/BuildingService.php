<?php

namespace RltBundle\Service;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Psr\Log\LoggerInterface;
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
     * @return array
     *
     * @throws \ReflectionException
     */
    public function parseLinks(): array
    {
        $offset = 0;
        $content = '';
        $result = [];

        $content = file_get_contents(__DIR__ . '/');
        $result[] = $this->parseItemForLink($content);
//        while (true) {
//            $param = 'o:' . $offset * static::PAGE_SIZE;
//            //$content = $this->request($param);
//            if (empty($content)) {
//                break;
//            }
//            $result[] = $this->parseItemForLink($content);
//            ++$offset;
//        }
//        return \array_merge(...$result);
    }

    /**
     * @param string $content
     * @return array
     */
    protected function parseItemForLink(string $content): array
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
        \array_filter($result);
        \ksort($result);
        return $result;
    }

    /**
     * @param string $link
     * @return int
     */
    protected function parseExtId(string $link): int
    {
        return preg_replace('/.+\/novostroyki\/(\d+).+/ui','$1', $link) ?? 0;
    }

    /**
     * @return string
     */
    protected function parseItem(string $link): BuildingDTO
    {
        return '';
    }

        /**
         * @return array
         */
    protected function parseDOM(): array
    {
        return [];
    }
}
