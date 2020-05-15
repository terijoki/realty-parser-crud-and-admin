<?php

namespace RltBundle\Command;

use RltBundle\Service\MetroService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MetroParserCommand extends Command
{
    protected MetroService $service;

    /**
     * EntityParserCommand constructor.
     *
     * @param MetroService $service
     */
    public function __construct(MetroService $service) {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * BuildingNewParser Configurate.
     */
    protected function configure(): void
    {
        $this
            ->setName('parser:new-metro')
            ->setDescription('Parse all metro stations in SPb')
            ->addArgument('city', InputOption::VALUE_REQUIRED, 'Passes city id')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('Starting parser...');

        $this->service->parseMetro($input->getArgument('city'));

        $output->writeln('Parser finished!');
    }
}
