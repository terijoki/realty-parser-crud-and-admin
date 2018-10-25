<?php

namespace RltBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository
{
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
     * Entity full signature (with bundle name, like "ApiBundle:User").
     *
     * @return string
     */
    public function getEntitySignature(): string
    {
        return 'RltBundle:Group';
    }
}
