<?php

namespace RltBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * BuildingRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BuildingRepository extends EntityRepository
{
    public const TABLE = 'rlt_buildings';
    public const NAME = 'RltBundle:Building';

    /**
     * Entity full signature (with bundle name, like "RltBundle:User").
     *
     * @return string
     */
    public function getEntitySignature(): string
    {
        return self::NAME;
    }

    /**
     * Alias for table that will be used in DQL.
     *
     * @return string
     */
    public function getAlias(): string
    {
        return 'b';
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     *
     * @return array|int[]
     */
    public function getExternalIds(): array
    {
        $sql = 'SELECT external_id FROM rlt_buildings';
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
