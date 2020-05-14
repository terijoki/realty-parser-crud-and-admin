<?php

namespace RltBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\City;
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

    public function parseMetro(): void
    {
        $result = $this->simpleRequest(self::API_URI .'/'. self::HH_CITY_ID);
        $metro = json_decode($result, true);

        foreach ($metro['lines'] as $line) {
            foreach ($line['stations'] as $station) {
                $entity = (new Metro())
                    ->setCity($this->em->getReference(City::class, City::SPB_ID))
                    ->setLine($line['name'])
                    ->setName($station['name']);

                $this->em->persist($entity);
            }
        }
        $this->em->flush();
    }

    protected function parseItemForLinks(array $content): array
    {
    }
}
