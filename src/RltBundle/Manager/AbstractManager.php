<?php

namespace RltBundle\Manager;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMInvalidArgumentException;
use Proxies\__CG__\RltBundle\Entity\City;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Building;
use RltBundle\Entity\EntityInterface;
use RltBundle\Entity\User;
use RltBundle\Service\BaseService;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

abstract class AbstractManager
{
    protected const NAME = '';
    protected const DELAY = 5;
    protected const ERROR_PARSE_TAG = 'parse-tag';
    protected const IMAGES_PATH = '/../../../var/images/';
    private const NUMBER = 0;
    private const MONTH = 1;
    private const YEAR = 2;

    protected $em;

    protected $logger;

    protected $service;

    protected $externalId;

    protected $entity;

    protected $user;

    protected $city;

    /**
     * AbstractManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param LoggerInterface        $logger
     * @param BaseService        $service
     */
    public function __construct(EntityManagerInterface $em, LoggerInterface $logger, BaseService $service)
    {
        $this->em = $em;
        $this->logger = $logger;
        $this->service = $service;
        $this->user = $this->em->getRepository(User::class)->findOneBy([
            'username' => User::ADMIN,
        ]);
        $this->city = $this->em->getReference(City::class, City::SPB_ID);
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
     * @param array $imagesPath
     *
     * @throws \ReflectionException
     *
     * @return array
     */
    protected function uploadImages(array $imagesPath): array
    {
        $images = [];
        foreach ($imagesPath as $imagePath) {
            $images[] = $this->uploadImage($imagePath, $this->externalId);
            \sleep(static::DELAY);
        }

        return $images;
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
        $uploadPath = __DIR__ . self::IMAGES_PATH . static::NAME . '/' . $id . '/';
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

    /**
     * @param string $class
     * @param int    $id
     *
     * @return object[]
     */
    protected function findByExternalId(string $class, int $id)
    {
        return $this->em->getRepository($class)->findOneBy([
            'externalId' => $id,
        ]);
    }

    /**
     * @param string $date
     *
     * @return DateTime
     */
    protected function convertToDatetime(?string $date): ?\DateTime
    {
        $converted = $result = null;
        $exploded = \explode(' ', $date);

        foreach (Building::$monthes as $month => $numberMonth) {
            if (!empty(array_filter($exploded)) && $month === $exploded[self::MONTH]) {
                $result = $exploded[self::YEAR] . '-' . $numberMonth . '-' . $exploded[self::NUMBER];
                $converted = new \DateTime($result);

                break;
            }
        }
        if (!empty($converted) && !$converted instanceof \DateTime) {
            throw new UnexpectedTypeException($result . ' value doesn`t match the format Y-m-d', (new \DateTime())->format('Y-m-d'));
        }

        return $converted;
    }
}
