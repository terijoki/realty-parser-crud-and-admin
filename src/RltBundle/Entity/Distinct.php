<?php

namespace RltBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Distinct.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "name"})
 *
 * @ORM\Table(name="rlt_distincts")
 * @ORM\Entity(repositoryClass="RltBundle\Repository\DistinctRepository")
 */
class Distinct
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
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $distinct;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Distinct
     */
    public function setId(int $id): Distinct
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistinct(): string
    {
        return $this->distinct;
    }

    /**
     * @param string $distinct
     * @return Distinct
     */
    public function setDistinct(string $distinct): Distinct
    {
        $this->distinct = $distinct;
        return $this;
    }
}