<?php

namespace RltBundle\Manager\FillerManager;

use RltBundle\Entity\Bank;
use RltBundle\Entity\Building;
use RltBundle\Entity\Developer;
use RltBundle\Entity\EntityInterface;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Entity\Model\NewsDTO;
use RltBundle\Entity\News;
use RltBundle\Manager\AbstractManager;
use RltBundle\Service\BaseService;
use RltBundle\Service\BankService;
use RltBundle\Service\BuildingService;
use RltBundle\Service\DeveloperService;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class NewsFillerManager extends AbstractManager implements FillItemInterface
{
    protected const NAME = 'news';

    private $validator;

    /**
     * NewsFillerManager constructor.
     *
     * @param $em
     * @param $logger
     * @param ValidatorInterface $validator
     * @param BaseService    $service
     */
    public function __construct($em, $logger, ValidatorInterface $validator, ParseListInterface $service)
    {
        parent::__construct($em, $logger, $service);
        $this->validator = $validator;
        $this->service = $service;
    }

    /**
     * @param NewsDTO $dto
     * @param int     $externalId
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \ReflectionException
     *
     * @return EntityInterface
     */
    public function fillEntity(DTOInterface $dto, int $externalId): EntityInterface
    {
        $this->externalId = $externalId;

        $this->entity = (new News())
            ->setName($dto->getName())
            ->setExternalId($externalId)
            ->setTitle($dto->getTitle())
            ->setDate($dto->getDate())
            ->setImages($this->uploadImages($dto->getImages()))
            ->setText($dto->getText())
            ->setCity($this->city)
            ->setUserCreator($this->user);

        $this->setRelatedEntites($dto->getRelatedEntities());

        return $this->entity;
    }

    /**
     * @param array $data
     */
    private function setRelatedEntites(array $data): void
    {
        foreach ($data as $key => $id) {
            switch ($key) {
                case BuildingService::SUFFIX:
                    /** @var Building $building */
                    $building = $this->findByExternalId(Building::class, $id);
                    $this->entity->setBuilding($building);

                    break;
                case DeveloperService::SUFFIX:
                    /** @var Developer $developer */
                    $developer = $this->findByExternalId(Developer::class, $id);
                    $this->entity->setDeveloper($developer);

                    break;
                case BankService::SUFFIX:
                    /** @var Bank $bank */
                    $bank = $this->findByExternalId(Bank::class, $id);
                    $this->entity->setBank($bank);

                    break;
            }
        }
    }
}
