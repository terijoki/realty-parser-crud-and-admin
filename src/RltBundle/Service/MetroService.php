<?php

namespace RltBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\City;
use RltBundle\Entity\Metro;

/**
 * Class MetroParserService.
 */
class MetroService extends BaseService
{
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

    public function parseMetro(int $cityId): void
    {
        $result = json_decode($this->simpleRequest(self::API_URI .'/'. $cityId), true);
        $stations = $this->em
            ->getRepository(Metro::class)
            ->getStationNames($cityId) ?? [];

        foreach ($result['lines'] as $line) {
            foreach ($line['stations'] as $station) {
                if(!in_array($station['name'], $stations)) {
                    $entity = (new Metro())
                        ->setCity($this->em->getReference(City::class, $cityId))
                        ->setLine($line['name'])
                        ->setName($station['name']);

                    $this->em->persist($entity);
                }
            }
        }
        $this->em->flush();
    }

    protected function parseItemForLinks(array $content, string $selector): array
    {
    }
}
