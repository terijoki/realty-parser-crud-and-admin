<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\BuildingNewParserCommand;
use RltBundle\Entity\Building;
use RltBundle\Entity\Model\BuildingDTO;
use RltBundle\Manager\BuildingParserManager;
use RltBundle\Manager\BuildingValidatorManager;
use RltBundle\Tests\RltTestCase;

/**
 * @coversNothing
 */
class BuildingCommandTest extends RltTestCase
{
    public function dataProvider(): array
    {
        return [[1], [2], [3], [4], [5]];
    }

    /**
     * @dataProvider dataProvider
     *
     * @param int $item
     */
    public function testExecuteCommand($item)
    {
        $file = __DIR__ . '/../../../../var/mock/building' . $item . '.html';
        $data = \file_get_contents($file);

        /** @var BuildingNewParserCommand $mock */
        $mock = $this->getMockBuilder(BuildingNewParserCommand::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'process',
            ])
            ->getMock()
        ;

        $mock->parser = $this->getContainer()->get(BuildingParserManager::class);
        /** @var BuildingDTO $dto */
        $dto = $mock->parser->parseItem($data, $item);

        $mock->validator = $this->getContainer()->get(BuildingValidatorManager::class);
        /** @var Building $entity */
        $entity = $mock->validator->fillEntity($dto, $item);

        $this->em->persist($entity);
        $this->em->flush();
    }
}
