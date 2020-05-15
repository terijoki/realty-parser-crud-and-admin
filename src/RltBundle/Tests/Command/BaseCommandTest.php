<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\EntityParserCommand;
use RltBundle\Entity\EntityInterface;
use RltBundle\Entity\Model\DTOInterface;
use RltBundle\Tests\RltTestCase;

/**
 * @coversNothing
 */
class BaseCommandTest extends RltTestCase
{
    public const PATH_TO_MOCK_FILE = '/../../../../var/mock/';

    /**
     * @param string $entityName
     * @param string $commandClass
     * @param string $managerClass
     * @param string $validatorClass
     *
     * @return EntityInterface $entity
     */
    protected function handleCommand(
        string $entityName,
        string $commandClass,
        string $managerClass,
        string $validatorClass
    ): EntityInterface
    {
        $filePath = __DIR__ . self::PATH_TO_MOCK_FILE . $entityName .'1.html';
        $data = \file_get_contents($filePath);

        /** @var EntityParserCommand $mock */
        $mock = $this->getMockBuilder($commandClass)
            ->disableOriginalConstructor()
            ->setMethods([
                'process',
            ])
            ->getMock()
        ;

        $mock->parser = $this->getContainer()->get($managerClass);
        /** @var DTOInterface $dto */
        $dto = $mock->parser->parseItem($data, 1);

        $mock->validator = $this->getContainer()->get($validatorClass);
        /** @var EntityInterface $entity */
        $entity = $mock->validator->fillEntity($dto, 1);

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }
}
