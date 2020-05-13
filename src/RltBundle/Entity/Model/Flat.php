<?php

namespace RltBundle\Entity\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Flat
{
    /**
     * @var int
     *
     * @Assert\Type(type="float")
     */
    private $rooms;

    /**
     * @var null|float
     *
     * @Assert\Type(type="float")
     */
    private $size;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     */
    private $cost;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     */
    private $costPerM2;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     */
    private $img;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     */
    private $buildDate;

    /**
     * @return int
     */
    public function getRooms(): int
    {
        return $this->rooms;
    }

    /**
     * @param int $rooms
     *
     * @return Flat
     */
    public function setRooms(int $rooms): Flat
    {
        $this->rooms = $rooms;

        return $this;
    }

    /**
     * @return null|float
     */
    public function getSize(): ?float
    {
        return $this->size;
    }

    /**
     * @param null|string $size
     *
     * @return Flat
     */
    public function setSize(?string $size): Flat
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCost(): ?string
    {
        return $this->cost;
    }

    /**
     * @param null|string $cost
     *
     * @return Flat
     */
    public function setCost(?string $cost): Flat
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCostPerM2(): ?string
    {
        return $this->costPerM2;
    }

    /**
     * @param null|string $costPerM2
     *
     * @return Flat
     */
    public function setCostPerM2(?string $costPerM2): Flat
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
     *
     * @return Flat
     */
    public function setImg(?string $img): Flat
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBuildDate(): ?string
    {
        return $this->buildDate;
    }

    /**
     * @param null|string $buildDate
     *
     * @return Flat
     */
    public function setBuildDate(?string $buildDate): Flat
    {
        $this->buildDate = $buildDate;

        return $this;
    }
}
