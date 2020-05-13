<?php

namespace RltBundle\Tests\DataFixtures\Group;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\MappingException;
use RltBundle\Entity\Group;

final class GroupDefaultFixture extends AbstractGroupFixture
{
    protected const NAME = 'client';
    protected const ROLE = 'ROLE_CLIENT';
}
