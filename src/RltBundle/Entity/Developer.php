<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Developer.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "name"})
 *
 * @ORM\Table(name="rlt_developers")
 * @ORM\Entity(repositoryClass="RltBundle\Repository\DeveloperRepository")
 */
class Developer
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
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     *
     * @ORM\Column(name="external_id", type="smallint", unique=true)
     */
    private $externalId;

    /**
     * @var null|int
     *
     * @Assert\Type(type="integer")
     * @Assert\Length(
     *      min = 6,
     *      max = 12,
     *      message = "You must enter a valid phone number",
     * )
     *
     * @ORM\Column(name="phone", type="integer", unique=true, nullable=true)
     */
    private $phone;

    /**
     * @var null|string
     *
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true)
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=true)
     */
    private $email;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true, nullable=true)
     */
    private $site;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="address", type="string", unique=true, nullable=true)
     */
    private $address;

    /**
     * @var null|int
     *
     * @Assert\Type(type="integer")
     * @Assert\Range(min=1900, max=2018, message = "You must enter a valid year")
     *
     * @ORM\Column(name="creation_year", type="smallint", nullable=true)
     */
    private $creationYear;

    /**
     * @var Building[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Building", mappedBy="developer", cascade={"persist"})
     */
    private $buildings;

    /**
     * @var News[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\News", mappedBy="developer", cascade={"persist"})
     */
    private $news;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="logo", type="string", nullable=true)
     *
     */
    private $logo;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * Developer constructor.
     */
    public function __construct()
    {
        $this->accreditated = new ArrayCollection();
        $this->news = new ArrayCollection();
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
     * @return Developer
     */
    public function setId(int $id): Developer
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
     * @return Developer
     */
    public function setName(string $name): Developer
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getExternalId(): int
    {
        return $this->externalId;
    }

    /**
     * @param int $externalId
     * @return Developer
     */
    public function setExternalId(int $externalId): Developer
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getPhone(): ?int
    {
        return $this->phone;
    }

    /**
     * @param int|null $phone
     * @return Developer
     */
    public function setPhone(?int $phone): Developer
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     * @return Developer
     */
    public function setEmail(?string $email): Developer
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSite(): ?string
    {
        return $this->site;
    }

    /**
     * @param null|string $site
     * @return Developer
     */
    public function setSite(?string $site): Developer
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     * @return Developer
     */
    public function setAddress(?string $address): Developer
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCreationYear(): ?int
    {
        return $this->creationYear;
    }

    /**
     * @param int|null $creationYear
     * @return Developer
     */
    public function setCreationYear(?int $creationYear): Developer
    {
        $this->creationYear = $creationYear;
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
     * @return Developer
     */
    public function setBuildings(array $buildings): Developer
    {
        $this->buildings = $buildings;
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
     * @return Developer
     */
    public function setNews(array $news): Developer
    {
        $this->news = $news;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLogo(): ?string
    {
        return $this->logo;
    }

    /**
     * @param null|string $logo
     * @return Developer
     */
    public function setLogo(?string $logo): Developer
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     * @return Developer
     */
    public function setDescription(?string $description): Developer
    {
        $this->description = $description;
        return $this;
    }
}