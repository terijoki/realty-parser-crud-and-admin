<?php

namespace RltBundle\Tests\DataFixtures\Group;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\MappingException;
use RltBundle\Entity\Group;

final class GroupModeratorFixture extends AbstractGroupFixture
{
    protected const NAME = 'moderator';
    protected const ROLE = 'ROLE_MODERATOR';
}
