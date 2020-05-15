<?php

namespace RltBundle\Manager\FillerManager;

use RltBundle\Entity\EntityInterface;
use RltBundle\Entity\Model\DTOInterface;

/**
 * Interface FillItemInterface.
 *
 * @Annotation
 */
interface FillItemInterface
{
    /**
     * @param DTOInterface $dto
     * @param int          $externalId
     *
     * @return EntityInterface
     */
    public function fillEntity(DTOInterface $dto, int $externalId): EntityInterface;
}
