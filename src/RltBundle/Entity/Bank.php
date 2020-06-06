<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use RltBundle\Entity\Building;
use RltBundle\Entity\Files\BankFiles;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bank.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "name"})
 *
 * @ORM\Table(name="rlt_banks",
 *     indexes={
 *         @ORM\Index(name="rlt_banks_name_idx", columns={"name"})
 *     })
 *     @ORM\Entity(repositoryClass="RltBundle\Repository\BankRepository")
 */
class Bank implements EntityInterface
{
    /**
     * @var int
     *
     * @Serializer\Groups({"getShortBank"})
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\Groups({"getShortBank"})
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
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    private $address;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="phone", type="string", unique=true, nullable=true)
     */
    private $phone;

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
     * @Assert\Range(min=1800, max=2018, invalidMessage="You must enter a valid year")
     *
     * @ORM\Column(name="creation_year", type="smallint", nullable=true)
     */
    private $creationYear;

    /**
     * @var Building[]
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToMany(targetEntity="RltBundle\Entity\Building", mappedBy="accreditation", fetch="EXTRA_LAZY")
     */
    private $accreditated;

    /**
     * @var News[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\News", mappedBy="bank", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    private $news;

    /**
     * @var ArrayCollection|BankFiles[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Files\BankFiles", mappedBy="entity", fetch="EAGER", orphanRemoval=true, cascade={"persist"})
     */
    private $logo;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var City
     * @Assert\Blank()
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\City", inversedBy="banks", fetch="EXTRA_LAZY", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @var User
     * @Assert\Blank()
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\User", inversedBy="banksCreated", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="user_creator", referencedColumnName="id")
     */
    private $userCreator;

    /**
     * @var null|User
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\User", inversedBy="banksUpdated", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="user_updater", referencedColumnName="id", nullable=true)
     */
    private $userUpdater;

    /**
     * Bank constructor.
     */
    public function __construct()
    {
        $this->accreditated = new ArrayCollection();
        $this->news = new ArrayCollection();
        $this->logo = new ArrayCollection();
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
     *
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
     *
     * @return Bank
     */
    public function setExternalId(int $externalId): Bank
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param null|string $phone
     *
     * @return Bank
     */
    public function setPhone(?string $phone): Bank
    {
        $this->phone = $phone;

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
     *
     * @return Bank
     */
    public function setAddress(?string $address): Bank
    {
        $this->address = $address;

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
     *
     * @return Bank
     */
    public function setSite(?string $site): Bank
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getCreationYear(): ?int
    {
        return $this->creationYear;
    }

    /**
     * @param null|int $creationYear
     *
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
     *
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
     *
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     *
     * @return Bank
     */
    public function setDescription(?string $description): Bank
    {
        $this->description = $description;

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
     * @return Bank
     */
    public function setCity(City $city): Bank
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return User
     */
    public function getUserCreator(): User
    {
        return $this->userCreator;
    }

    /**
     * @param User $userCreator
     *
     * @return Bank
     */
    public function setUserCreator(User $userCreator): Bank
    {
        $this->userCreator = $userCreator;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getUserUpdater(): ?User
    {
        return $this->userUpdater;
    }

    /**
     * @param null|User $userUpdater
     *
     * @return Bank
     */
    public function setUserUpdater(?User $userUpdater): Bank
    {
        $this->userUpdater = $userUpdater;

        return $this;
    }
}
