<?php

namespace RltBundle\Tests\DataFixtures\Group;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\MappingException;
use RltBundle\Entity\Group;

final class GroupUserFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @throws MappingException
     * @throws \ReflectionException
     */
    public function load(ObjectManager $manager): void
    {
        $group = new Group();
        $group
            ->setId(3)
            ->setName('user')
            ->setRoles([
                'ROLE_USER',
            ])
        ;

        $manager->persist($group);
        $manager->flush();

        $this->addReference(static::class, $group);
    }
}
