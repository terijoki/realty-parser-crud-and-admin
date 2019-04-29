<?php

namespace RltBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
{
    public const TABLE = 'rlt_user_groups';
    public const NAME = 'RltBundle:Group';

    /**
     * Alias for table that will be used in DQL.
     *
     * @return string
     */
    public function getAlias(): string
    {
        return 'g';
    }

    /**
     * Entity full signature (with bundle name, like "RltBundle:User").
     *
     * @return string
     */
    public function getEntitySignature(): string
    {
        return self::NAME;
    }
}
