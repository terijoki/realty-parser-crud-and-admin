<?php

namespace RltBundle\Manager;

use RltBundle\Entity\EntityInterface;
use RltBundle\Entity\Model\DTOInterface;

/**
 * Interface ValidateItemInterface.
 *
 * @Annotation
 */
interface ValidateItemInterface
{
    /**
     * @param DTOInterface $dto
     * @param int          $externalId
     *
     * @return EntityInterface
     */
    public function createEntity(DTOInterface $dto, int $externalId): EntityInterface;
}
