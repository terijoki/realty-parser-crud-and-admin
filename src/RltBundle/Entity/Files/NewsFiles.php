<?php

namespace RltBundle\Entity\Files;

use Doctrine\ORM\Mapping as ORM;
use RltBundle\Entity\News;

/**
 * @ORM\Entity()
 */
class NewsFiles extends Files
{
    /**
     * @var News
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\News", inversedBy="images", fetch="LAZY")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entity;

    /**
     * @return News
     */
    public function getEntity(): News
    {
        return $this->entity;
    }

    /**
     * @param News $entity
     * @return NewsFiles
     */
    public function setEntity($entity): NewsFiles
    {
        $this->entity = $entity;

        return $this;
    }
}