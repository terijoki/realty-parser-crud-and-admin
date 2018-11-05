<?php

namespace RltBundle\Manager;

use RltBundle\Entity\Building;
use RltBundle\Entity\Developer;
use RltBundle\Entity\EntityInterface;
use RltBundle\Entity\Model\DeveloperDTO;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Service\AbstractService;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class DeveloperValidatorManager extends AbstractManager implements ValidateItemInterface
{
    protected const NAME = 'developers';

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * DeveloperValidatorManager constructor.
     *
     * @param $em
     * @param $logger
     * @param ValidatorInterface $validator
     * @param AbstractService    $service
     */
    public function __construct($em, $logger, ValidatorInterface $validator, ParseListInterface $service)
    {
        parent::__construct($em, $logger, $service);
        $this->validator = $validator;
        $this->service = $service;
    }

    /**
     * @param DeveloperDTO $dto
     * @param int          $externalId
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \ReflectionException
     *
     * @return EntityInterface
     */
    public function fillEntity(DTOInterface $dto, int $externalId): EntityInterface
    {
        $entity = new Developer();
        $entity
            ->setName($dto->getName())
            ->setExternalId($externalId)
            ->setAddress($dto->getAddress())
            ->setPhone($dto->getPhone())
            ->setEmail($dto->getEmail())
            ->setSite($dto->getSite())
            ->setDescription($dto->getDescription())
            ->setLogo($this->uploadImage($dto->getLogo(), $externalId))
            ->setCreationYear($dto->getCreated())
            ->setUserCreator($this->user)
        ;
        //todo make autoSet Datetime of create and update building (timestampable)

        return $entity;
    }
}
