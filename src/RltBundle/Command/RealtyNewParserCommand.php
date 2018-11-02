<?php

namespace RltBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Manager\ParseItemInterface;
use RltBundle\Manager\ValidateItemInterface;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RealtyNewParserCommand extends AbstractParserCommand
{
    /**
     * RealtyNewParserCommand constructor.
     *
     * @param EntityManagerInterface $em
     * @param LoggerInterface        $logger
     * @param ContainerInterface     $container
     * @param ParseListInterface     $service
     * @param ParseItemInterface     $parser
     * @param ValidateItemInterface  $validator
     */
    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface        $logger,
        ContainerInterface     $container,
        ParseListInterface     $service,
        ParseItemInterface     $parser,
        ValidateItemInterface  $validator
    ) {
        parent::__construct($em, $logger, $container, $service, $parser, $validator);
    }

    /**
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function process(): void
    {
        $buildingDTO = $this->parser->parseItem('a', 1);
        $building = $this->validator->createEntity($buildingDTO, 1);
        die;

        $links = $this->service->parseLinks();

        foreach ($links as $id => $link) {
            if ($this->isUnique($id)) {
                $item = $this->service->getItem($link);
                $dto = $this->parser->parseItem($item, $id);
                $entity = $this->validator->createEntity($dto, $id);
                $this->em->persist($entity);
            }
        }
    }

    /**
     * @param string $externalId
     *
     * @return bool
     */
    protected function isUnique(string $externalId): bool
    {
        return !\in_array($externalId, $this->storedIds, true);
    }
}
