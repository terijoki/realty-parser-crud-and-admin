<?php

namespace RltBundle\Command;

use Symfony\Component\Console\Input\InputOption;

class BankParserCommand extends EntityParserCommand
{
    protected const NAME = 'RltBundle:Bank';
    protected const LINKS_SELECTOR = 'li > a[class="company"]';

    /**
     * BankNewParser Configurate.
     */
    protected function configure(): void
    {
        $this
            ->setName('parser:new-banks')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Parse all data without checking for unique')
            ->setDescription('Checks building site for new banks and parse them')
        ;
    }
}
