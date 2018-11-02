<?php

namespace RltBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMInvalidArgumentException;
use Psr\Log\LoggerInterface;
use RltBundle\Service\ParseListInterface;

abstract class AbstractManager
{
    protected const MIN_DELAY = 3;
    protected const MAX_DELAY = 10;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ParseListInterface
     */
    protected $service;

    /**
     * @var int
     */
    protected $externalId;

    /**
     * AbstractManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param LoggerInterface        $logger
     * @param ParseListInterface     $service
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, ParseListInterface $service)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->service = $service;
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

    /**
     * @param string $imagePath
     * @param int    $id
     *
     * @throws \ReflectionException
     *
     * @return string
     */
    protected function uploadImage(string $imagePath, int $id): string
    {
        $localName = \preg_replace('/.+\/(.+.jpg)/ui', '$1', $imagePath);
        $image = $this->service->simpleRequest($imagePath);
        $uploadPath = ROOT . '/var/images/' . $id . '/';
        $path = $uploadPath . $localName;

        try {
            if (!\file_exists($uploadPath)) {
                \mkdir($uploadPath);
            }
            \file_put_contents($path, $image);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), ['category' => 'images-upload']);
        }

        return $path;
    }
}
