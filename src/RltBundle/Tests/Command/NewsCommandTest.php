<?php

namespace RltBundle\Tests\Command;

use RltBundle\Command\NewsParserCommand;
use RltBundle\Entity\News;
use RltBundle\Manager\FillerManager\NewsFillerManager;
use RltBundle\Manager\ParserManager\NewsParserManager;

/**
 * @coversNothing
 */
class NewsCommandTest extends BaseCommandTest
{
    public function testExecuteCommand()
    {
        $newsItem = $this->handleCommand(
            'news',
            NewsParserCommand::class,
            NewsParserManager::class,
            NewsFillerManager::class,
        );

        $this->assertInstanceOf(News::class, $newsItem);
    }
}
