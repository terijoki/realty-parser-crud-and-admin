<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\NewsNewParserCommand;
use RltBundle\Entity\News;
use RltBundle\Manager\NewsParserManager;
use RltBundle\Manager\NewsValidatorManager;

/**
 * @coversNothing
 */
class NewsCommandTest extends BaseCommandTest
{
    public function testExecuteCommand()
    {
        $newsItem = $this->handleCommand(
            'news',
            NewsNewParserCommand::class,
            NewsParserManager::class,
            NewsValidatorManager::class,
        );

        $this->assertInstanceOf(News::class, $newsItem);
    }
}
