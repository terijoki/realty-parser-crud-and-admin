<?php

namespace RltBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMInvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * AbstractManager constructor.
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

    /**
     * @param $entity
     *
     * @throws ORMInvalidArgumentException
     */
    public function refreshEntityChanges($entity): void
    {
        $uow = $this->em->getUnitOfWork();
        if (!$uow->isScheduledForDelete($entity)) {
            $this->em->persist($entity);
        }
        $meta = $this->em->getClassMetadata(\get_class($entity));

        if ($uow->getEntityChangeSet($entity)) {
            $uow->recomputeSingleEntityChangeSet($meta, $entity);

            return;
        }

        $uow->computeChangeSet($meta, $entity);
    }
}
