<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\BuildingNewParserCommand;
use RltBundle\Entity\Building;
use RltBundle\Manager\BuildingParserManager;
use RltBundle\Manager\BuildingValidatorManager;

/**
 * @coversNothing
 */
class BuildingCommandTest extends BaseCommandTest
{
    public function testExecuteCommand()
    {
        $building = $this->handleCommand(
            'building',
            BuildingNewParserCommand::class,
            BuildingParserManager::class,
            BuildingValidatorManager::class,
        );

        $this->assertInstanceOf(Building::class, $building);
    }
}
