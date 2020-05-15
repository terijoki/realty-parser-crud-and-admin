<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\BankParserCommand;
use RltBundle\Entity\Bank;
use RltBundle\Manager\FillerManager\BankFillerManager;
use RltBundle\Manager\ParserManager\BankParserManager;

/**
 * @coversNothing
 */
class BankCommandTest extends BaseCommandTest
{
    public function testExecuteCommand()
    {
        $bank = $this->handleCommand(
            'bank',
            BankParserCommand::class,
            BankParserManager::class,
            BankFillerManager::class,
        );

        $this->assertInstanceOf(Bank::class, $bank);
    }
}
