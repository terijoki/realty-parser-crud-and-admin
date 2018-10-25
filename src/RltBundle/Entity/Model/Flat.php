<?php

namespace RltBundle\Entity\Model\Zone;

use Symfony\Component\Validator\Constraints as Assert;

class Flat
{
    /**
     * @var null|float
     *
     * @Assert\Type(type="float")
     */
    private $size;

    /**
     * @var null|int
     *
     * @Assert\Type(type="integer")
     */
    private $cost;

    /**
     * @var null|int
     *
     * @Assert\Type(type="integer")
     */
    private $costPerM2;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     */
    private $img;

    /**
     * @var null|int
     *
     * @Assert\Type(type="integer")
     * @Assert\Range(min=1900, max=2018, message = "You must enter a valid year")
     */
    private $buildDate;

    /**
     * @return float|null
     */
    public function getSize(): ?float
    {
        return $this->size;
    }

    /**
     * @param float|null $size
     * @return Flat
     */
    public function setSize(?float $size): Flat
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCost(): ?int
    {
        return $this->cost;
    }

    /**
     * @param int|null $cost
     * @return Flat
     */
    public function setCost(?int $cost): Flat
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCostPerM2(): ?int
    {
        return $this->costPerM2;
    }

    /**
     * @param int|null $costPerM2
     * @return Flat
     */
    public function setCostPerM2(?int $costPerM2): Flat
    {
        $this->costPerM2 = $costPerM2;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param null|string $img
     * @return Flat
     */
    public function setImg(?string $img): Flat
    {
        $this->img = $img;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getBuildDate(): ?int
    {
        return $this->buildDate;
    }

    /**
     * @param int|null $buildDate
     * @return Flat
     */
    public function setBuildDate(?int $buildDate): Flat
    {
        $this->buildDate = $buildDate;
        return $this;
    }
}