<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\BankNewParserCommand;
use RltBundle\Entity\Bank;
use RltBundle\Manager\BankParserManager;
use RltBundle\Manager\BankValidatorManager;

/**
 * @coversNothing
 */
class BankCommandTest extends BaseCommandTest
{
    public function testExecuteCommand()
    {
        $bank = $this->handleCommand(
            'bank',
            BankNewParserCommand::class,
            BankParserManager::class,
            BankValidatorManager::class,
        );

        $this->assertInstanceOf(Bank::class, $bank);
    }
}
