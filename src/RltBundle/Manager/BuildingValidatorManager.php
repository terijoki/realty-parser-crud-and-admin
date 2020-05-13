<?php

namespace RltBundle\Manager;

use Doctrine\ORM\NoResultException;
use RltBundle\Entity\Bank;
use RltBundle\Entity\Building;
use RltBundle\Entity\Developer;
use RltBundle\Entity\Distinct;
use RltBundle\Entity\EntityInterface;
use RltBundle\Entity\Metro;
use RltBundle\Entity\Model\BuildingDTO;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Service\AbstractService;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BuildingValidatorManager extends AbstractManager implements ValidateItemInterface
{
    protected const NAME = 'buildings';

    protected const ECONOM = 'Эконом класс';
    protected const COMFORT = 'Комфорт-класс';
    protected const BUSINESS = 'Бизнес-класс';
    protected const ELITE = 'Элит-класс';

    protected const MONOLIT = 'Монолитный';
    protected const PANEL = 'Панельный';
    protected const BRICK_MONOLIT = 'Кирпично-монолитный';
    protected const CARCASS_MONOLIT = 'Каркасно-монолитный';
    protected const BRICK = 'Кирпичный';

    protected const WITHOUT = 'без отделки';
    protected const WITH = 'с отделкой';
    protected const WITH_AND_WITHOUT = 'с отделкой и без';

    protected const INSTALMENTS = 'рассрочка';
    protected const IPOTEKA = 'ипотека';
    protected const ANY = 'ипотека и рассрочка';

    protected const ZHSK = 'ЖСК';
    protected const DDU = '214 ФЗ';

    protected const YES = 'Есть';

    private ValidatorInterface $validator;

    /**
     * BuildingValidatorManager constructor.
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
     * @param BuildingDTO $dto
     * @param int         $externalId
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \ReflectionException
     *
     * @return EntityInterface
     */
    public function fillEntity(DTOInterface $dto, int $externalId): EntityInterface
    {
        $this->externalId = $externalId;

        $this->entity = (new Building())
            ->setName($dto->getName())
            ->setExternalId($externalId)
            ->setAddress($dto->getAddress())
            ->setFlatCount($dto->getFlatCount())
            ->setParking($dto->getParking())
            ->setExternalUpdated($this->convertToDatetime($dto->getUpdated()))
            ->setDescription($dto->getDescription())
            ->setOurOpinition($dto->getOurOpinition())
            ->setPrice($dto->getPrice())
            ->setPricePerM2($dto->getPricePerM2())
            ->setFlats($dto->getFlats())
            ->setUserCreator($this->user)
            ->setImages($this->uploadImages($dto->getImages()))
        ;
        //todo make autoSet Datetime of create and update building (timestampable)

        $this->validateBuilding($dto);

        return $this->entity;
    }

    /**
     * Additional validation for entity.
     *
     * @param BuildingDTO $dto
     *
     * @throws \ReflectionException
     */
    private function validateBuilding(DTOInterface $dto): void
    {
        $this->setValidatedMetro($dto->getMetro());
        $this->setValidatedDeveloper($dto->getDeveloper());
        $this->setValidatedAccreditation($dto->getAccreditation());
        $this->setValidatedDistinct($dto->getAddress());
        $this->setValidatedStatus($dto->getStatus());
        $this->setValidatedClass($dto->getClass());
        $this->setValidatedPermission($dto->getPermission());
        $this->setValidatedType($dto->getBuildType());
        $this->setValidatedFacing($dto->getFacing());
        $this->setValidatedPaymentType($dto->getPaymentType());
        $this->setValidatedContractType($dto->getContractType());
        $this->setValidatedPermission($dto->getPermission());
        $this->setValidatedBuildDate($dto->getBuildDate());
    }

    /**
     * @param string $metro
     */
    private function setValidatedMetro(string $metro): void
    {
        /** @var Metro[] $allStations */
        $allStations = $this->em->getRepository(Metro::class)->findAll();

        $exploded = \explode(',', $metro);
        foreach ($exploded as $item) {
            foreach ($allStations as $station) {
                if ($station->getName() === \trim($item)) {
                    $this->entity->addMetro($station);
                }
            }
        }
    }

    /**
     * @param string $developer
     */
    private function setValidatedDeveloper(string $developer): void
    {
        try {
            /** @var Developer $developer */
            $developer = $this->em->getRepository(Developer::class)->findOneBy(['name' => $developer]);
        } catch (NoResultException $noResultException) {
            $this->logger->critical($noResultException->getMessage(), ['category' => 'parse-validator']);
        }
        $this->entity->setDeveloper($developer);
    }

    /**
     * @param array $bankNames
     */
    private function setValidatedAccreditation(array $bankNames): void
    {
        /** @var Bank[] $banks */
        $banks = $this->em->getRepository(Bank::class)->findBy(['name' => $bankNames]) ?? [];
        $this->entity->setAccreditation($banks);
    }

    /**
     * @param string $address
     */
    private function setValidatedDistinct(string $address): void
    {
        $exploded = \explode(',', $address);

        try {
            /** @var Distinct $distinct */
            $distinct = $this->em->getRepository(Distinct::class)->findOneBy(['distinct' => $exploded[0]]);
        } catch (NoResultException $noResultException) {
            $this->logger->critical($noResultException->getMessage(), ['category' => 'parse-validator']);
        }
        $this->entity->setDistinct($distinct);
    }

    /**
     * @param null|bool $status
     */
    private function setValidatedStatus(?bool $status): void
    {
        $this->entity->setStatus((true === $status) ? $status : false);
    }

    /**
     * @param null|string $class
     */
    private function setValidatedClass(?string $class): void
    {
        switch ($class) {
            case self::ECONOM:
                $this->entity->setClass(Building::ECONOM);

                break;
            case self::COMFORT:
                $this->entity->setClass(Building::COMFORT);

                break;
            case self::BUSINESS:
                $this->entity->setClass(Building::BUSINESS);

                break;
            case self::ELITE:
                $this->entity->setClass(Building::ELITE);

                break;
        }
    }

    /**
     * @param null|string $type
     */
    private function setValidatedType(?string $type): void
    {
        switch ($type) {
            case self::MONOLIT:
                $this->entity->setBuildType(Building::MONOLIT);

                break;
            case self::PANEL:
                $this->entity->setBuildType(Building::PANEL);

                break;
            case self::BRICK_MONOLIT:
                $this->entity->setBuildType(Building::BRICK_MONOLIT);

                break;
            case self::CARCASS_MONOLIT:
                $this->entity->setBuildType(Building::CARCASS_MONOLIT);

                break;
            case self::BRICK:
                $this->entity->setBuildType(Building::BRICK);

                break;
        }
    }

    /**
     * @param null|string $facing
     */
    private function setValidatedFacing(?string $facing): void
    {
        switch ($facing) {
            case self::WITHOUT:
                $this->entity->setFacing(Building::WITHOUT);

                break;
            case self::WITH:
                $this->entity->setFacing(Building::WITH);

                break;
            case self::WITH_AND_WITHOUT:
                $this->entity->setFacing(Building::WITH_AND_WITHOUT);

                break;
        }
    }

    /**
     * @param null|string $payment
     */
    private function setValidatedPaymentType(?string $payment): void
    {
        switch ($payment) {
            case self::INSTALMENTS:
                $this->entity->setPaymentType(Building::WITHOUT);

                break;
            case self::IPOTEKA:
                $this->entity->setPaymentType(Building::IPOTEKA);

                break;
            case self::ANY:
                $this->entity->setPaymentType(Building::ANY);

                break;
        }
    }

    /**
     * @param null|string $contract
     */
    private function setValidatedContractType(?string $contract): void
    {
        switch ($contract) {
            case self::ZHSK:
                $this->entity->setContractType(Building::ZHSK);

                break;
            case self::DDU:
                $this->entity->setContractType(Building::DDU);

                break;
        }
    }

    /**
     * @param null|string $permission
     */
    private function setValidatedPermission(?string $permission): void
    {
        $this->entity->setPermission(self::YES === $permission);
    }

    /**
     * @param null|array $items
     */
    private function setValidatedBuildDate(array $items): void
    {
        $result = [];
        $slice = 0;
        $count = \count($items);
        while ($count > 0) {
            $string = '';
            for ($i = 0; $i < 3; ++$i) {
                $string .= $items[$slice] . ' ';
                ++$slice;
                --$count;
                if (0 === $count) {
                    break;
                }
            }
            $result[] = $string;
        }

        $this->entity->setBuildDate($result);
    }
}
