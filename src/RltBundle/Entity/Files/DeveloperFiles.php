<?php

namespace RltBundle\Entity\Files;

use Doctrine\ORM\Mapping as ORM;
use RltBundle\Entity\Developer;

/**
 * @ORM\Entity()
 */
class DeveloperFiles extends Files
{
    /**
     * @var Developer
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Developer", inversedBy="logo", fetch="LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entity;

    /**
     * @return Developer
     */
    public function getEntity(): Developer
    {
        return $this->entity;
    }

    /**
     * @param Developer $entity
     * @return DeveloperFiles
     */
    public function setEntity($entity): DeveloperFiles
    {
        $this->entity = $entity;

        return $this;
    }
}