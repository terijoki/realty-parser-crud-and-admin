<?php

namespace RltBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * District.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "name"})
 *
 * @ORM\Table(name="rlt_districts", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="rlt_district_city_uindex", columns={"name", "city_id"})
 * })
 * @ORM\Entity
 */
class District
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $district;

    /**
     * @var City
     * @Assert\Blank()
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\City", inversedBy="districts", fetch="EXTRA_LAZY", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return District
     */
    public function setId(int $id): District
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->district;
    }

    /**
     * @param string $district
     *
     * @return District
     */
    public function setDistrict(string $district): District
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     * @return District
     */
    public function setCity(City $city): District
    {
        $this->city = $city;

        return $this;
    }
}
