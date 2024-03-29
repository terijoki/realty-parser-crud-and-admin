<?php

namespace RltBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DeveloperRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DeveloperRepository extends EntityRepository
{
    public const TABLE = 'rlt_developers';
    public const NAME = 'RltBundle:Developer';

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
        return 'd';
    }

    /**
     * @throws \Doctrine\DBAL\DBALException
     *
     * @return array|int[]
     */
    public function getExternalIds(): array
    {
        $sql = 'SELECT external_id FROM rlt_developers';
        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
