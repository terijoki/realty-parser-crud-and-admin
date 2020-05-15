<?php

namespace RltBundle\Command;

use Symfony\Component\Console\Input\InputOption;

class NewsParserCommand extends EntityParserCommand
{
    protected const NAME = 'RltBundle:News';
    protected const LINKS_SELECTOR = 'li > a';

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
