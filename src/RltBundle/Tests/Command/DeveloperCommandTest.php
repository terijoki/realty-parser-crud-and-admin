<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\DeveloperParserCommand;
use RltBundle\Entity\Developer;
use RltBundle\Manager\FillerManager\DeveloperFillerManager;
use RltBundle\Manager\ParserManager\DeveloperParserManager;

/**
 * @coversNothing
 */
class DeveloperCommandTest extends BaseCommandTest
{
    public function testExecuteCommand()
    {
        $developer = $this->handleCommand(
            'developer',
            DeveloperParserCommand::class,
            DeveloperParserManager::class,
            DeveloperFillerManager::class,
        );

        $this->assertInstanceOf(Developer::class, $developer);
    }
}
