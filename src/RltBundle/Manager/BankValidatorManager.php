<?php

namespace RltBundle\Manager;

use RltBundle\Entity\Bank;
use RltBundle\Entity\Building;
use RltBundle\Entity\EntityInterface;
use RltBundle\Entity\Model\BankDTO;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Service\AbstractService;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BankValidatorManager extends AbstractManager implements ValidateItemInterface
{
    protected const NAME = 'banks';

    private ValidatorInterface $validator;

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
    }

    /**
     * @param BankDTO $dto
     * @param int     $externalId
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \ReflectionException
     *
     * @return EntityInterface
     */
    public function fillEntity(DTOInterface $dto, int $externalId): EntityInterface
    {
        return (new Bank())
            ->setName($dto->getName())
            ->setExternalId($externalId)
            ->setAddress($dto->getAddress())
            ->setPhone($dto->getPhone())
            ->setSite($dto->getSite())
            ->setDescription($dto->getDescription())
            ->setLogo($this->uploadImage($dto->getLogo(), $externalId))
            ->setCreationYear($dto->getCreated())
            ->setUserCreator($this->user)
        ;
    }
}
