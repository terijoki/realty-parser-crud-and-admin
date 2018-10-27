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
abstract class AbstractService
{
    protected const URN = '';
    protected const EXPIRATION = 0;

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

//    /**
//     * @return array
//     * @throws \ReflectionException
//     */
//    public function parse(): array
//    {
//        $data = [];
//
//        if ($this->useCache) {
//            $key = $this->createCacheKey($link);
//            if ($this->redis->exists($key)) {
//                $response[] = $this->redis->get($key);
//            }
//            $data[] = $this->parseItem($link);
//
//            $this->redis->setex($key, static::EXPIRATION, $data);
//        } else {
//            $data[] = $this->parseItem($link);
//        }
//    }

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
     * @param mixed $param
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    protected function request($param): string
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
    protected function simpleRequest($link, $params = []): string
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
                'category' => 'post-error',
            ]);

            return '';
        }
    }

    /**
     * @return array
     */
    abstract public function parseLinks(): array;

    /**
     * @param string $link
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    abstract public function getItem(string $link): string;
}
