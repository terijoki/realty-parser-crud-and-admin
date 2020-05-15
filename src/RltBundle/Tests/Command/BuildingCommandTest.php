<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\BuildingParserCommand;
use RltBundle\Entity\Building;
use RltBundle\Manager\FillerManager\BuildingFillerManager;
use RltBundle\Manager\ParserManager\BuildingParserManager;

/**
 * @coversNothing
 */
class BuildingCommandTest extends BaseCommandTest
{
    public function testExecuteCommand()
    {
        $building = $this->handleCommand(
            'building',
            BuildingParserCommand::class,
            BuildingParserManager::class,
            BuildingFillerManager::class,
        );

        $this->assertInstanceOf(Building::class, $building);
    }
}
