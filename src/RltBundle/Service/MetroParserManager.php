<?php

namespace RltBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Metro;

/**
 * Class BuildingService.
 */
class MetroParserManager extends AbstractService
{
    private const HH_CITY_ID = 2;
    private const API_URI = 'https://api.hh.ru/metro';

    protected EntityManagerInterface $em;

    public function __construct(
        string $url,
        LoggerInterface $logger,
        RedisService $redis,
        EntityManagerInterface $em
    )
    {
        parent::__construct($url, $logger, $redis);
        $this->em = $em;
    }

    public function parseMetro()
    {
        $result = $this->simpleRequest(self::API_URI .'/'. self::HH_CITY_ID);
var_dump($result);die;
        foreach ($result['lines'] as $line) {
            foreach ($line['stations'] as $station) {
                (new Metro())->setName($station['status']);

                $this->em->persist($entity);
            }
        }
    }

    protected function parseItemForLinks(array $content): array
    {
    }
}
