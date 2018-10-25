<?php

namespace RltBundle\Service;

use Predis\Client as Predis;

class RedisService
{
    private $client;

    public function __construct(string $redisHost = 'localhost')
    {
        $this->client = new Predis([
            'scheme' => 'tcp',
            'host' => $redisHost,
            'port' => 6379,
        ]);
    }

    public function getClient()
    {
        return $this->client;
    }
}
