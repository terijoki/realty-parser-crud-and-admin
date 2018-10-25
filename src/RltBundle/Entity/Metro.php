<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Distinct.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "name"})
 *
 * @ORM\Table(name="rlt_metro")
 * @ORM\Entity(repositoryClass="RltBundle\Repository\MetroRepository")
 */
class Metro
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
     * @ORM\Column(name="name", type="string", length=255, unique=true, nullable=false)
     */
    private $name;

    /**
     * @var Building[]
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Building", mappedBy="metro", fetch="EXTRA_LAZY")
     */
    private $buildings;

    /**
     * Metro constructor.
     */
    public function __construct()
    {
        $this->buildings = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Metro
     */
    public function setId(int $id): Metro
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Metro
     */
    public function setName(string $name): Metro
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Building[]
     */
    public function getBuildings(): array
    {
        return $this->buildings;
    }

    /**
     * @param Building[] $buildings
     * @return Metro
     */
    public function setBuildings(array $buildings): Metro
    {
        $this->buildings = $buildings;
        return $this;
    }
}