<?php

namespace RltBundle\Tests\DataFixtures\Group;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\MappingException;
use RltBundle\Entity\Group;

abstract class AbstractGroupFixture extends Fixture
{
    protected const NAME = '';
    protected const ROLE = '';

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
            ->setName(static::NAME)
            ->setRoles([static::ROLE])
        ;

        $manager->persist($group);
        $manager->flush();

        $this->addReference(static::class, $group);
    }
}
