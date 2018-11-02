<?php

namespace RltBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Manager\BuildingParserManager;
use RltBundle\Manager\BuildingValidatorManager;
use RltBundle\Manager\ParseItemInterface;
use RltBundle\Manager\ValidateItemInterface;
use RltBundle\Service\BuildingService;
use RltBundle\Service\ParseListInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Stopwatch\Stopwatch;

abstract class AbstractParserCommand extends Command
{
    use LockableTrait;

    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var null|ContainerInterface
     */
    protected $container;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var BuildingService
     */
    protected $service;

    /**
     * @var BuildingParserManager
     */
    protected $parser;

    /**
     * @var BuildingValidatorManager
     */
    protected $validator;

    /**
     * @var array
     */
    protected $storedIds;

    /**
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * RealtyNewParserCommand constructor.
     *
     * @param EntityManagerInterface $em
     * @param ContainerInterface     $container
     * @param LoggerInterface        $logger
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
        parent::__construct();
        $this->em = $em;
        $this->logger = $logger;
        $this->container = $container;
        $this->service = $service;
        $this->parser = $parser;
        $this->validator = $validator;
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
        $this->input = $input;
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

        $stopwatch = new Stopwatch();
        $stopwatch->start($this->getName());

        $this->io = new SymfonyStyle($input, $output);
        $this->io->writeln((new \DateTime())->format('Y-m-d H:i:s') . ' Run');
        $this->logger->info('Run ' . $this->getName(), [
            'class' => (new \ReflectionClass(static::class))->getShortName(),
            'category' => 'parser-command',
        ]);

        try {
            $this->process();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage(), [
                'class' => (new \ReflectionClass(static::class))->getShortName(),
                'category' => 'parser-command',
            ]);
        }

        $this->io->success((new \DateTime())->format('Y-m-d H:i:s') . ' Done.');
        $event = $stopwatch->stop($this->getName());
        $this->io->text($event->__toString());

        $this->logger->info($event->__toString(), [
            'class' => (new \ReflectionClass(static::class))->getShortName(),
            'category' => 'parser-command',
        ]);

        $this->release();
    }

    abstract protected function process(): void;
}
