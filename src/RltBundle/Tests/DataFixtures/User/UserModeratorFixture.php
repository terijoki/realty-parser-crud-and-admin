<?php

namespace RltBundle\Tests\DataFixtures\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RltBundle\Entity\Group;
use RltBundle\Entity\User;
use RltBundle\Tests\DataFixtures\Group\GroupModeratorFixture;

final class UserModeratorFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        /** @var Group $group */
        $group = $this->getReference(GroupModeratorFixture::class);

        $user = new User();
        $user
            ->setUsername('moderator')
            ->setEmail('moderator@mail.ru')
            ->setPlainPassword('123456')
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
            GroupModeratorFixture::class,
        ];
    }
}
