<?php

namespace RltBundle\Entity\Files;

use Doctrine\ORM\Mapping as ORM;
use RltBundle\Entity\Bank;

/**
 * @ORM\Entity()
 */
class BankFiles extends Files
{
    /**
     * @var Bank
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Bank", inversedBy="logo", fetch="LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entity;

    /**
     * @return Bank
     */
    public function getEntity(): Bank
    {
        return $this->entity;
    }

    /**
     * @param Bank $entity
     * @return BankFiles
     */
    public function setEntity($entity): BankFiles
    {
        $this->entity = $entity;

        return $this;
    }
}