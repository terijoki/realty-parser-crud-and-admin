<?php

namespace RltBundle\Entity\Files;

use Doctrine\ORM\Mapping as ORM;
use RltBundle\Entity\Building;

/**
 * @ORM\Entity()
 */
class BuildingFiles extends Files
{
    /**
     * @var Building
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Building", inversedBy="images", fetch="LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entity;

    /**
     * @return Building
     */
    public function getEntity(): Building
    {
        return $this->entity;
    }

    /**
     * @param Building $entity
     * @return BuildingFiles
     */
    public function setEntity($entity): BuildingFiles
    {
        $this->entity = $entity;

        return $this;
    }
}