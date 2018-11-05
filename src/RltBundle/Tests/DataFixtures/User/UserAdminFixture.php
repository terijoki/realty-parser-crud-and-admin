<?php

namespace RltBundle\Tests\DataFixtures\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use RltBundle\Entity\User;

final class UserAdminFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setId(1)
            ->setUsername('admin')
            ->setEmail('admin@mail.ru')
            ->setPassword(123456)
            ->setCreatedAt(new \DateTime())
        ;

        $manager->persist($user);
        $manager->flush();

        $this->addReference(static::class, $user);
    }
}
