<?php

namespace RltBundle\Manager;

use RltBundle\Entity\Bank;
use RltBundle\Entity\Building;
use RltBundle\Entity\EntityInterface;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Entity\User;
use RltBundle\Service\AbstractService;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BankValidatorManager extends AbstractManager implements ValidateItemInterface
{
    /**
     * @var EntityInterface
     */
    private $entity;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * BankValidatorManager constructor.
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
        $this->entity = new Bank();
    }

    /**
     * @return EntityInterface
     */
    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    /**
     * @param DTOInterface $dto
     * @param int          $externalId
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \ReflectionException
     *
     * @return EntityInterface
     */
    public function createEntity(DTOInterface $dto, int $externalId): EntityInterface
    {
        /** @var User $user */
        $user = $this->em->getReference(User::class, User::PARSER);
        $this->entity
            ->setName($dto->getName())
            ->setExternalId($externalId)
            ->setAddress($dto->getAddress())
            ->setPhone($dto->getPhone())
            ->setSite($dto->getSite())
            ->setDescription($dto->getDescription())
            ->setLogo($this->uploadImage($dto->getLogo(), $externalId))
            ->setCreationYear($dto->getCreated())
            ->setUserCreator($user)
        ;
        //todo make autoSet Datetime of create and update building (timestampable)

        return $this->getEntity();
    }
}
