<?php

namespace RltBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Building;
use RltBundle\Manager\BuildingParserManager;
use RltBundle\Manager\BuildingValidatorManager;
use RltBundle\RltBundle;
use RltBundle\Service\BuildingService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BuildingParserCommand extends Command
{
    use LockableTrait;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var null|ContainerInterface
     */
    private $container;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var BuildingService
     */
    private $service;

    /**
     * @var BuildingParserManager
     */
    private $parser;

    /**
     * @var BuildingValidatorManager
     */
    private $validator;

    /**
     * @var array
     */
    private $storedIds;

    /**
     * BuildingParserCommand constructor.
     *
     * @param EntityManagerInterface $em
     * @param ContainerInterface     $container
     * @param LoggerInterface        $logger
     * @param BuildingService        $buildingService
     * @param BuildingParserManager  $manager
     */
    public function __construct(
        EntityManagerInterface $em,
        LoggerInterface $logger,
        ContainerInterface $container,
        BuildingService $service,
        BuildingParserManager $parser,
        BuildingValidatorManager $validator
    ) {
        parent::__construct();
        $this->em = $em;
        $this->logger = $logger;
        $this->container = $container;
        $this->service = $service;
        $this->parser = $parser;
        $this->validator = $validator;
    }

    protected function configure(): void
    {
        $this
            ->setName('parser:new-buildings')
            ->addOption('cache', 'c', InputOption::VALUE_NONE, 'Use cache for store data')
            ->setDescription('Checks building site for new realty and parse them')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @throws \ReflectionException
     *
     * @return null|int|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $today = new \DateTime();
        $this->output->writeln($today->format('Y-m-d H:i:s') . ' run');

        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return;
        }

        if ($input->hasOption('cache') && $input->getOption('cache')) {
            $this->service->useCache(true);
        }

        $buildingDTO = $this->parser->parseBuilding('a', 1);
        $building = $this->validator->createEntity($buildingDTO, 1);
        die;

        $links = $this->service->parseLinks();

        //maybe use getReference?
        $this->storedIds = $this->em->getRepository(Building::class)->getExternalIds();

        foreach ($links as $id => $link) {
            if ($this->isUnique($id)) {
                $item = $this->service->getItem($link);
                $buildingDTO = $this->parser->parseBuilding($item, $id);
                $building = $this->validator->createEntity($buildingDTO, $id);
                $this->em->persist($building);
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
