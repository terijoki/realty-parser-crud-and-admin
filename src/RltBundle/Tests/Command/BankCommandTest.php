<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\BankNewParserCommand;
use RltBundle\Command\BuildingNewParserCommand;
use RltBundle\Entity\Bank;
use RltBundle\Entity\Model\BankDTO;
use RltBundle\Manager\BankParserManager;
use RltBundle\Manager\BankValidatorManager;
use RltBundle\Tests\RltTestCase;

/**
 * @coversNothing
 */
class BankCommandTest extends RltTestCase
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
        $file = __DIR__ . '/../../../../var/mock/bank' . $item . '.html';
        $data = \file_get_contents($file);

        /** @var BuildingNewParserCommand $mock */
        $mock = $this->getMockBuilder(BankNewParserCommand::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'process',
            ])
            ->getMock()
        ;

        $mock->parser = $this->getContainer()->get(BankParserManager::class);
        /** @var BankDTO $dto */
        $dto = $mock->parser->parseItem($data, $item);

        $mock->validator = $this->getContainer()->get(BankValidatorManager::class);
        /** @var Bank $entity */
        $entity = $mock->validator->fillEntity($dto, $item);

        $this->em->persist($entity);
        $this->em->flush();
    }
}
