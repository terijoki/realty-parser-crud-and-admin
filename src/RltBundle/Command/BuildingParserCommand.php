<?php

namespace RltBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Entity\Building;
use RltBundle\Manager\BuildingManager;
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
     * @var BuildingManager
     */
    private $manager;

    /**
     * BuildingParserCommand constructor.
     *
     * @param EntityManagerInterface $em
     * @param ContainerInterface     $container
     * @param LoggerInterface        $logger
     * @param BuildingService        $buildingService
     * @param BuildingManager        $manager
     */
    public function __construct(
        EntityManagerInterface $em,
        ContainerInterface $container,
        LoggerInterface $logger,
        BuildingService $service,
        BuildingManager $manager
    ) {
        $this->container = $container;
        parent::__construct();
        $this->em = $em;
        $this->logger = $logger;
        $this->service = $service;
        $this->manager = $manager;
    }

    protected function configure(): void
    {
        $this
            ->setName('parser:new-buildings')
            ->addOption('cache', 'c', InputOption::VALUE_OPTIONAL, 'Use cache for store data', null)
            ->setDescription('Checks building site for new realty and parse them')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return null|int|void
     * @throws \ReflectionException
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

        $this->manager->createBuilding('a', 'b');die;

        $links = $this->service->parseLinks();

        //maybe use getReference?
        $this->storedIds = $this->em->getRepository('RltBundle:Building')->getExternalIds();

        foreach ($links as $link) {
            if ($this->isUnique($link)) {
                $item = $this->service->getItem($link);
                $this->manager->createBuilding($item);
            }
        }
    }

    final protected function isUnique(string $statId): bool
    {
        return !\in_array($statId, $this->storedIds, true);
    }
}