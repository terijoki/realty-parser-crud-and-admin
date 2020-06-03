<?php

namespace RltBundle\Entity\Files;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\Table(name="rlt_files")
 * @Vich\Uploadable
 */
abstract class Files
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=21300)
     * @Assert\NotBlank
     */
    protected $value;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    protected $entityType;

    /**
     * @Vich\UploadableField(mapping="files", fileNameProperty="value")
     *
     * @var File
     */
    protected $entityFile;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getEntityType()
    {
        return $this->entityType;
    }

    /**
     * @param mixed $entityType
     */
    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $entityFile
     */
    public function setEntityFile(File $entityFile = null)
    {
        $this->entityFile = $entityFile;

        if (null !== $entityFile) {
            $this->setUpdatedAt(new \DateTime());
        }
    }

    /**
     * @return File
     */
    public function getEntityFile()
    {
        return $this->entityFile;
    }


    /**
     * @return mixed
     */
    abstract public function getEntity();

    /**
     * @param $entity
     * @return mixed
     */
    abstract public function setEntity($entity);

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}