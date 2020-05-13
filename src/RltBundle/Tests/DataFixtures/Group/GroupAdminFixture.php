<?php

namespace RltBundle\Tests\DataFixtures\Group;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\MappingException;
use RltBundle\Entity\Group;

final class GroupAdminFixture extends AbstractGroupFixture
{
    protected const NAME = 'admin';
    protected const ROLE = 'ROLE_ADMIN';
}
