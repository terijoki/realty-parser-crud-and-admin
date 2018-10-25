<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bank.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "name"})
 *
 * @ORM\Table(name="rlt_banks")
 * @ORM\Entity(repositoryClass="RltBundle\Repository\BankRepository")
 */
class Bank
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
     * @ORM\Column(name="site", type="string", length=255, unique=true, nullable=true)
     */
    private $site;

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
     * @ORM\ManyToMany(targetEntity="ApiBundle\Entity\Building", mappedBy="accreditation", fetch="EXTRA_LAZY")
     */
    private $accreditated;

    /**
     * @var News[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\News", mappedBy="bank", cascade={"persist"})
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
     * Bank constructor.
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
     * @return Bank
     */
    public function setId(int $id): Bank
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
     * @return Bank
     */
    public function setName(string $name): Bank
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
     * @return Bank
     */
    public function setExternalId(int $externalId): Bank
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
     * @return Bank
     */
    public function setPhone(?int $phone): Bank
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
     * @return Bank
     */
    public function setEmail(?string $email): Bank
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
     * @return Bank
     */
    public function setSite(?string $site): Bank
    {
        $this->site = $site;
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
     * @return Bank
     */
    public function setCreationYear(?int $creationYear): Bank
    {
        $this->creationYear = $creationYear;
        return $this;
    }

    /**
     * @return Building[]
     */
    public function getAccreditated(): array
    {
        return $this->accreditated;
    }

    /**
     * @param Building[] $accreditated
     * @return Bank
     */
    public function setAccreditated(array $accreditated): Bank
    {
        $this->accreditated = $accreditated;
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
     * @return Bank
     */
    public function setNews(array $news): Bank
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
     * @return Bank
     */
    public function setLogo(?string $logo): Bank
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
     * @return Bank
     */
    public function setDescription(?string $description): Bank
    {
        $this->description = $description;
        return $this;
    }
}