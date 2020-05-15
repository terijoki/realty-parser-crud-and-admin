<?php

namespace RltBundle\Service;

use Elastica\Exception\NotFoundException;
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
    public const USER_AGENT = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36';
    protected const SUFFIX = '';
    protected const EXPIRATION = 0;
    protected const PAGE_SIZE = 20;
    protected const DELAY = 5;
    protected const MAX_AVAILABLE_COUNT = 100;

    /**
     * @var Client
     */
    protected $client;

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
                'User-Agent' => self::USER_AGENT,
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
     * @param string $selector
     *
     * @return array
     */
    public function parseLinks(string $selector): array
    {
        $offset = 0;
        $contents = [];
        while ($offset < self::MAX_AVAILABLE_COUNT) {
            $param = $offset * static::PAGE_SIZE;
            $content = $this->request($param);
            if (\mb_strlen($content) < 10) {
                break;
            }
            $contents[] = $content;
            ++$offset;

            \sleep(self::DELAY);
        }

        return $this->parseItemForLinks($contents, $selector);
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
            $response = $this->client->post(static::SUFFIX, [
                RequestOptions::FORM_PARAMS => [
                    'o' => $param,
                ],
                RequestOptions::HEADERS => [
                    'X-Requested-With' => 'XMLHttpRequest',
                ],
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
    public function simpleRequest($link, $params = []): ?string
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
        } catch (NotFoundException $e) {
            return null;
        }
    }

    /**
     * @param string $link
     *
     * @return int
     */
    public function parseExtId(string $link, string $urn): int
    {
        return (int) \preg_replace('/.+\/' . $urn . '\/(\d+).+/ui', '$1', $link) ?? 0;
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
     * @param array $content
     * @param string $selector
     *
     * @return array
     */
    protected function parseItemForLinks(array $content, string $selector): array
    {
        $result = [];

        foreach ($content as $item) {
            $crawler = new Crawler($item);

            foreach ($crawler->filter($selector) as $li) {
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
