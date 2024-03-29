<?php

namespace RltBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use RltBundle\Manager\FillerManager\FillItemInterface;
use RltBundle\Manager\ParserManager\ParseItemInterface;
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

    protected const NAME = '';
    protected const EXPIRATION = 86400;
    protected const PAGE_SIZE = 20;
    protected const DELAY = 1;
    protected const ERROR_CATEGORY = 'parser-command';

    public $em;

    public $parser;

    public $validator;

    protected $logger;

    protected $container;

    protected $input;

    protected $output;

    protected $service;

    protected $storedIds;

    protected $io;

    /**
     * EntityParserCommand constructor.
     *
     * @param EntityManagerInterface $em
     * @param ContainerInterface     $container
     * @param LoggerInterface        $logger
     * @param ParseListInterface     $service
     * @param ParseItemInterface     $parser
     * @param FillItemInterface  $validator
     */
    public function __construct(
        ParseListInterface     $service,
        ParseItemInterface     $parser,
        FillItemInterface  $validator,
        EntityManagerInterface $em,
        ContainerInterface     $container,
        LoggerInterface        $logger
    ) {
        parent::__construct();
        $this->service = $service;
        $this->parser = $parser;
        $this->validator = $validator;
        $this->em = $em;
        $this->container = $container;
        $this->logger = $logger;
        $this->storedIds = $this->em->getRepository(static::NAME)->getExternalIds();
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

        $stopwatch = new Stopwatch();
        $stopwatch->start($this->getName());

        $this->io = new SymfonyStyle($input, $output);
        $this->logger->info('Run ' . $this->getName(), [
            'class' => (new \ReflectionClass(static::class))->getShortName(),
            'category' => self::ERROR_CATEGORY,
        ]);

        try {
            $this->process();
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage(), [
                'class' => (new \ReflectionClass(static::class))->getShortName(),
                'category' => self::ERROR_CATEGORY,
            ]);
        }

        $this->io->success((new \DateTime())->format('Y-m-d H:i:s') . ' Done.');
        $event = $stopwatch->stop($this->getName());
        $this->io->text($event->__toString());

        $this->logger->info($event->__toString(), [
            'class' => (new \ReflectionClass(static::class))->getShortName(),
            'category' => self::ERROR_CATEGORY,
        ]);

        $this->release();
    }

    abstract protected function process(): void;
}
