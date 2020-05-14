<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * City.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "name"})
 *
 * @ORM\Table(name="rlt_cities")
 * @ORM\Entity
 */
class City
{
    public const MOSCOW_ID = 1;
    public const SPB_ID = 2;
    public const MOSCOW_OBLAST_ID = 11;
    public const LENINGRAD_OBLAST_ID = 12;

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
    private $city;

    /**
     * @var Building[]
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToMany(targetEntity="RltBundle\Entity\Building", mappedBy="city", fetch="EXTRA_LAZY")
     */
    private $buildings;

    /**
     * @var District[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\District", mappedBy="city", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    private $districts;

    /**
     * @var Developer[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Developer", mappedBy="city", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    private $developers;

    /**
     * @var Bank[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Bank", mappedBy="city", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    private $banks;

    /**
     * @var News[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\News", mappedBy="city", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    private $news;

    /**
     * @var Metro[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Metro", mappedBy="city", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    private $metro;

    /**
     * City constructor.
     */
    public function __construct()
    {
        $this->buildings = new ArrayCollection();
        $this->districts = new ArrayCollection();
        $this->developers = new ArrayCollection();
        $this->banks = new ArrayCollection();
        $this->news = new ArrayCollection();
        $this->metro = new ArrayCollection();
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
     *
     * @return City
     */
    public function setId(int $id): City
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return City
     */
    public function setCity(string $city): City
    {
        $this->city = $city;

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
     * @return City
     */
    public function setBuildings(array $buildings): City
    {
        $this->buildings = $buildings;

        return $this;
    }

    /**
     * @return District[]
     */
    public function getDistricts(): array
    {
        return $this->districts;
    }

    /**
     * @param District[] $districts
     * @return City
     */
    public function setDistricts(array $districts): City
    {
        $this->districts = $districts;

        return $this;
    }

    /**
     * @return Metro[]
     */
    public function getMetro(): array
    {
        return $this->metro;
    }

    /**
     * @param Metro[] $metro
     * @return City
     */
    public function setMetro(array $metro): City
    {
        $this->metro = $metro;

        return $this;
    }

    /**
     * @return Developer[]
     */
    public function getDevelopers(): array
    {
        return $this->developers;
    }

    /**
     * @param Developer[] $developers
     * @return City
     */
    public function setDevelopers(array $developers): City
    {
        $this->developers = $developers;

        return $this;
    }

    /**
     * @return Bank[]
     */
    public function getBanks(): array
    {
        return $this->banks;
    }

    /**
     * @param Bank[] $banks
     * @return City
     */
    public function setBanks(array $banks): City
    {
        $this->banks = $banks;

        return $this;
    }

    /**
     * @return News[]
     */
    public function getNews(): array
    {
        return $this->news;
    }

    /**
     * @param News[] $news
     * @return City
     */
    public function setNews(array $news): City
    {
        $this->news = $news;

        return $this;
    }
}
