<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\DeveloperNewParserCommand;
use RltBundle\Entity\Developer;
use RltBundle\Manager\DeveloperParserManager;
use RltBundle\Manager\DeveloperValidatorManager;

/**
 * @coversNothing
 */
class DeveloperCommandTest extends BaseCommandTest
{
    public function testExecuteCommand()
    {
        $developer = $this->handleCommand(
            'developer',
            DeveloperNewParserCommand::class,
            DeveloperParserManager::class,
            DeveloperValidatorManager::class,
        );

        $this->assertInstanceOf(Developer::class, $developer);
    }
}
