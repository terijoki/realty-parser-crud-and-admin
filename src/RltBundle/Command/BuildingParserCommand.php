<?php

namespace RltBundle\Command;

use Symfony\Component\Console\Input\InputOption;

class BuildingParserCommand extends EntityParserCommand
{
    protected const NAME = 'RltBundle:Building';
    protected const LINKS_SELECTOR = 'li > a[class="n"]';

    /**
     * BuildingNewParser Configurate.
     */
    protected function configure(): void
    {
        $this
            ->setName('parser:new-buildings')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Parse all data without checking for unique')
            ->setDescription('Checks building site for new buildings and parse them')
        ;
    }
}
