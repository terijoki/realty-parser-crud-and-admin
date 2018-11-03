<?php

namespace RltBundle\Command;

use Symfony\Component\Console\Input\InputOption;

class NewsNewParserCommand extends EntityNewParserCommand
{
    protected const NAME = 'RltBundle:News';

    /**
     * NewsNewParser Configurate.
     */
    protected function configure(): void
    {
        $this
            ->setName('parser:new-news')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Parse all data without checking for unique')
            ->setDescription('Checks building site for new news and parse them')
        ;
    }
}
