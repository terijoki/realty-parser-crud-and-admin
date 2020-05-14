<?php

namespace RltBundle\Command;

use RltBundle\Service\MetroParserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MetroParserCommand extends Command
{
    protected MetroParserManager $service;

    /**
     * EntityNewParserCommand constructor.
     *
     * @param MetroParserManager $service
     */
    public function __construct(MetroParserManager $service) {
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
