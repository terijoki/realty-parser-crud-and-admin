<?php

namespace RltBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Building;
use RltBundle\Manager\ParseItemInterface;
use RltBundle\Manager\ValidateItemInterface;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BuildingNewParserCommand extends RealtyNewParserCommand
{
    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface        $logger,
        ContainerInterface     $container,
        ParseListInterface     $service,
        ParseItemInterface     $parser,
        ValidateItemInterface  $validator
    ) {
        parent::__construct($em, $logger, $container, $service, $parser, $validator);
        $this->storedIds = $this->em->getRepository(Building::class)->getExternalIds();
    }

    protected function configure(): void
    {
        $this
            ->setName('parser:new-buildings')
            ->addOption('cache', 'c', InputOption::VALUE_NONE, 'Use cache for store data')
            ->setDescription('Checks building site for new realty and parse them')
        ;
    }
}
