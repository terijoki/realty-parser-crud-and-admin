<?php

namespace RltBundle\Manager;

use ApiBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMInvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class Manager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Manager constructor.
     *
     * @param EntityManagerInterface $em
     * @param LoggerInterface        $logger
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    public function save(): void
    {
        $this->em->flush();
    }

//    /**
//     * @param $entity
//     *
//     * @throws ORMInvalidArgumentException
//     */
//    public function refreshEntityChanges($entity): void
//    {
//        $uow = $this->em->getUnitOfWork();
//        if (!$uow->isScheduledForDelete($entity)) {
//            $this->em->persist($entity);
//        }
//        $meta = $this->em->getClassMetadata(\get_class($entity));
//
//        if ($uow->getEntityChangeSet($entity)) {
//            $uow->recomputeSingleEntityChangeSet($meta, $entity);
//
//            return;
//        }
//
//        $uow->computeChangeSet($meta, $entity);
//    }

//    /**
//     * @return User
//     */
//    public function getUser(): User
//    {
//        if (null === $this->tokenStorage->getToken()) {
//            throw new \RuntimeException('User not logged in');
//        }
//        $user = $this->tokenStorage->getToken()->getUser();
//
//        if ($user instanceof User) {
//            return $user;
//        }
//
//        throw new \RuntimeException('User is not type of User');
//    }

//    /**
//     * @param string $method
//     * @param string $name
//     * @param object $object
//     * @param array  $oldData
//     * @param array  $newData
//     */
//    protected function commonLoggerChanges(string $method, string $name, object $object, array $oldData, array $newData): void
//    {
//        $user = $this->getUser();
//        $this->logger->info($method, [
//            $name => $object->getId(),
//            'user_id' => $user->getId(),
//            'user_name' => $user->getName(),
//            'old_data' => \json_encode($oldData, JSON_PRETTY_PRINT),
//            'new_data' => \json_encode($newData, JSON_PRETTY_PRINT),
//            'category' => $name . 's',
//        ]);
//    }

}
