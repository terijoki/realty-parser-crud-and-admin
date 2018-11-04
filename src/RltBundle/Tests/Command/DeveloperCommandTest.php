<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\BuildingNewParserCommand;
use RltBundle\Command\DeveloperNewParserCommand;
use RltBundle\Entity\Developer;
use RltBundle\Entity\Model\DeveloperDTO;
use RltBundle\Manager\DeveloperParserManager;
use RltBundle\Manager\DeveloperValidatorManager;
use RltBundle\Tests\RltTestCase;

/**
 * @coversNothing
 */
class DeveloperCommandTest extends RltTestCase
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
        $file = __DIR__ . '/../../../../var/mock/developer' . $item . '.html';
        $data = \file_get_contents($file);

        /** @var DeveloperNewParserCommand $mock */
        $mock = $this->getMockBuilder(BuildingNewParserCommand::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'process',
            ])
            ->getMock()
        ;

        $mock->parser = $this->getContainer()->get(DeveloperParserManager::class);
        /** @var DeveloperDTO $dto */
        $dto = $mock->parser->parseItem($data, $item);

        $mock->validator = $this->getContainer()->get(DeveloperValidatorManager::class);
        /** @var Developer $entity */
        $entity = $mock->validator->fillEntity($dto, $item);

        $this->em->persist($entity);
        $this->em->flush();
    }
}
