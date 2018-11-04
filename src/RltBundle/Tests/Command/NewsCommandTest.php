<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\BuildingNewParserCommand;
use RltBundle\Command\NewsNewParserCommand;
use RltBundle\Entity\Model\NewsDTO;
use RltBundle\Entity\News;
use RltBundle\Manager\NewsParserManager;
use RltBundle\Manager\NewsValidatorManager;
use RltBundle\Tests\RltTestCase;

/**
 * @coversNothing
 */
class NewsCommandTest extends RltTestCase
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
        $file = __DIR__ . '/../../../../var/mock/news' . $item . '.html';
        $data = \file_get_contents($file);

        /** @var BuildingNewParserCommand $mock */
        $mock = $this->getMockBuilder(NewsNewParserCommand::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'process',
            ])
            ->getMock()
        ;

        $mock->parser = $this->getContainer()->get(NewsParserManager::class);
        /** @var NewsDTO $dto */
        $dto = $mock->parser->parseItem($data, $item);

        $mock->validator = $this->getContainer()->get(NewsValidatorManager::class);
        /** @var News $entity */
        $entity = $mock->validator->fillEntity($dto, $item);

        $this->em->persist($entity);
        $this->em->flush();
    }
}
