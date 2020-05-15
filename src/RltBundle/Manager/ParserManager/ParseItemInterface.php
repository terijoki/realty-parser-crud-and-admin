<?php

namespace RltBundle\Manager\ParserManager;

use RltBundle\Entity\Model\DTOInterface;

/**
 * Interface ParseListInterface.
 *
 * @Annotation
 */
interface ParseItemInterface
{
    /**
     * @param string $item
     * @param int    $externalId
     *
     * @return DTOInterface
     */
    public function parseItem(string $item, int $externalId): DTOInterface;
}
