<?php

namespace RltBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MetroRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MetroRepository extends EntityRepository
{
    public const TABLE = 'rlt_metro';
    public const NAME = 'RltBundle:Metro';

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
        return 'm';
    }
}
