<?php

namespace RltBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AbstractService.
 */
abstract class AbstractService implements ParseListInterface
{
    protected const URN = '';
    protected const EXPIRATION = 0;
    protected const PAGE_SIZE = 0;
    protected const DELAY = 5;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var RedisService
     */
    protected $redis;

    /**
     * @var bool
     */
    protected $useCache = false;

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * Service constructor.
     *
     * @param LoggerInterface $logger
     * @param string          $url
     * @param RedisService    $redis
     */
    public function __construct(string $url, LoggerInterface $logger, RedisService $redis)
    {
        $this->logger = $logger;
        $this->redis = $redis->getClient();
        $this->client = new Client([
            'base_uri' => $url,
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
            ],
        ]);
    }

    /**
     * @param bool     $useCache
     * @param null|int $expiration
     */
    public function useCache(bool $useCache, int $expiration = null): void
    {
        if (null !== $expiration) {
            $this->cacheExpiration = static::EXPIRATION;
        }
        $this->useCache = $useCache;
    }

    /**
     * @param string $unique
     *
     * @return string
     */
    protected function createCacheKey(string $unique): string
    {
        $today = new \DateTime();

        return 'link_' . \hash('sha256', $unique . $today->format('Ymd'));
    }

    /**
     * @throws \ReflectionException
     *
     * @return array
     */
    public function parseLinks(): array
    {
        $offset = 0;
        $links = [];

        while (true) {
            $param = 'o:' . $offset * static::PAGE_SIZE;
            $content = $this->request($param);
            if (empty($content)) {
                break;
            }
            $links[] = $this->parseItemForLinks($content);
            $content = '';
            ++$offset;
            \sleep(self::DELAY);
        }

        return \array_merge(...$links);
    }

    /**
     * @param mixed $param
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    public function request($param): string
    {
        try {
            $response = $this->client->post(static::URN, [
                RequestOptions::BODY => $param,
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            $this->logger->error($e->getMessage(), [
                'class' => (new \ReflectionClass(static::class))->getShortName(),
                'request' => Psr7\str($e->getRequest()),
                'response' => Psr7\str($e->getResponse()),
                'category' => 'post-error',
            ]);

            return '';
        }
    }

    /**
     * @param $link
     * @param array $params
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    public function simpleRequest($link, $params = []): string
    {
        try {
            $response = $this->client->get($link, [
                RequestOptions::QUERY => $params,
            ]);

            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            $this->logger->error($e->getMessage(), [
                'class' => (new \ReflectionClass(static::class))->getShortName(),
                'request' => Psr7\str($e->getRequest()),
                'response' => Psr7\str($e->getResponse()),
                'category' => 'get-error',
            ]);

            return '';
        }
    }

    /**
     * @param string $link
     *
     * @return int
     */
    public function parseExtId(string $link, string $urn): int
    {
        return \preg_replace('/.+\/' . $urn . '\/(\d+).+/ui', '$1', $link) ?? 0;
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

    /**
     * @param string $content
     *
     * @return array
     */
    abstract protected function parseItemForLinks(string $content): array;
}
