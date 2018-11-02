<?php

namespace RltBundle\Command;

use Symfony\Component\Console\Input\InputOption;

class DeveloperNewParserCommand extends RealtyNewParserCommand
{
    protected const NAME = 'RltBundle:Developer';

    /**
     * DeveloperNewParser Configurate.
     */
    protected function configure(): void
    {
        $this
            ->setName('parser:new-developers')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Parse all data without checking for unique')
            ->setDescription('Checks building site for new developers and parse them')
        ;
    }
}
