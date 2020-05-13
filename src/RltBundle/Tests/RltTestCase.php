<?php

namespace RltBundle\Tests;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use RltBundle\Entity\User;
use RltBundle\Tests\DataFixtures\User\UserAdminFixture;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RltTestCase extends WebTestCase
{
    public const ADMIN = 'admin';
    public const MODERATOR = 'moderator';
    public const CLIENT = 'client';

    protected ContainerInterface $container;
    protected ?EntityManagerInterface $em;
    protected Client $client;

    private $needToLoadFixture = true;
    private $createAuthUser = true;
    private ?User $user;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();
        $this->container = $kernel->getContainer();
        $this->em = $this->container
            ->get('doctrine')
            ->getManager()
        ;

        if (true === $this->needToLoadFixture) {
            $loader = new Loader();
            $loader->addFixture(new UserAdminFixture());

            $purger = new ORMPurger($this->em, []);

            $executor = new ORMExecutor($this->em, $purger);
            $executor->execute($loader->getFixtures());

            if (true === $this->createAuthUser) {
//                $this->createAuthUser();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->getConnection()->close();
        $this->em->close();
        $this->em = null;
    }

    /**
     * @return null|User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return RltTestCase
     */
    public function setContainer(ContainerInterface $container): RltTestCase
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @param string $username
     */
    private function createAuthUser($username = self::ADMIN): void
    {
        $jwtManager = $this->container->get('lexik_jwt_authentication.jwt_manager');
        $this->user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);

        if (null === $this->user) {
            throw new \RuntimeException('User not found');
        }

        $token = $jwtManager->create($this->getUser());

        $this->client = static::createClient();
        $this->client->setServerParameter('HTTP_Authorization', 'Bearer '. $token);
        $this->client->setServerParameter('CONTENT_TYPE', 'application/json');
    }

    /**
     * @param ORMFixtureInterface[] $fixtures
     * @param bool                  $append
     */
    protected function loadFixtures(array $fixtures, bool $append = true): void
    {
        $loader = new Loader();
        foreach ($fixtures as $fixture) {
            if ($fixture instanceof ORMFixtureInterface) {
                $loader->addFixture($fixture);
            } else {
                throw new \UnexpectedValueException('Fixture should implement ORMFixtureInterface');
            }
        }
        $executor = new ORMExecutor($this->em, new ORMPurger());
        $executor->execute($loader->getFixtures(), $append);
    }

    /**
     * @param int $id
     */
    protected function loginById(int $id): void
    {
        $data = [
            1 => [
                'login' => 'admin',
            ],
            2 => [
                'login' => 'moderator',
            ],
            3 => [
                'login' => 'client',
            ],
        ];

        $this->createAuthUser($data[$id]['login']);
    }
}
