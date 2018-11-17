<?php

namespace RltBundle\Tests\DataFixtures\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RltBundle\Entity\Group;
use RltBundle\Entity\User;
use RltBundle\Tests\DataFixtures\Group\GroupDefaultFixture;

final class CustomUserFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        /** @var Group $group */
        $group = $this->getReference(GroupDefaultFixture::class);

        $user = new User();
        $user
            ->setId(3)
            ->setUsername('custom')
            ->setPassword(123456)
            ->addGroup($group)
            ->setCreatedAt(new \DateTime())
        ;

        $manager->persist($user);
        $manager->flush();

        $this->addReference(static::class, $user);
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            GroupDefaultFixture::class,
        ];
    }
}
