<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use RltBundle\Entity\Model\Zone\Flat;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Building.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "name"})
 *
 * @ORM\Table(name="rlt_buildings")
 * @ORM\Entity(repositoryClass="RltBundle\Repository\BuildingRepository")
 */
class Building
{
    /**
     * Realty classes.
     */
    public const OTHER_CLASS = 0;
    public const ELITE = 1;
    public const BUSINESS = 2;
    public const COMFORT = 3;
    public const ECONOM = 4;

    /**
     * Realty types.
     */
    public const OTHER_TYPE = 0;
    public const MONOLIT = 1;
    public const PANEL = 2;
    public const BRICK_MONOLIT = 3;
    public const CARCASS_MONOLIT = 4;
    public const BRICK = 5;

    /**
     * Contract types.
     */
    public const ZHSK = 0;
    public const DDU = 1;

    /**
     * Facing types.
     */
    public const WITHOUT = 0;
    public const WITH = 1;
    public const WITH_AND_WITHOUT = 2;

    /**
     * Payment types.
     */
    public const INSTALMENTS = 0;
    public const IPOTEKA = 1;

    /**
     * Status.
     */
    public const IN_PROCESS = 0;
    public const READY = 1;

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
     * @var Distinct
     *
     * @Assert/Valid
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Distinct", cascade={"persist"})
     * @ORM\JoinColumn(name="distinct_id", referencedColumnName="id", nullable=false)
     */
    private $distinct;

    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     *
     * @ORM\Column(name="external_id", type="int", unique=true)
     */
    private $externalId;

    /**
     * @var Metro[]
     *
     * @ORM\ManyToMany(targetEntity="Metro", inversedBy="buildings", cascade={"persist"})
     * @ORM\JoinTable(name="rlt_buildings_metro",
     *     joinColumns={@ORM\JoinColumn(name="building_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="metro_id", referencedColumnName="id")}
     * )
     */
    private $metro;

    /**
     * @var null|int
     *
     * @Assert\Type(type="int")
     *
     * @ORM\Column(name="class", type="smallint", nullable=true)
     */
    private $class;

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
     * @Assert\Type(type="int")
     *
     * @ORM\Column(name="build_type", type="smallint", nullable=true)
     */
    private $buildType;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="floors", type="string", nullable=true)
     */
    private $floors;

    /**
     * @var Developer
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Developer", inversedBy="buildings")
     * @ORM\JoinColumn(name="developer_id", referencedColumnName="id", nullable=false)
     */
    private $developer;

    /**
     * @var null|bool
     *
     * @Assert\Type(type="boolean")
     * @Assert\Choice(choices={
     *     Building::ZHSK,
     *     Building::DDU
     * }, message="Choose a valid contract type", strict=true)
     *
     * @ORM\Column(name="contract_type", type="boolean", nullable=true)
     */
    private $contractType;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="flat_count", type="string", length=255, nullable=true)
     */
    private $flatCount;

    /**
     * @var bool
     *
     * @Assert\Type(type="boolean")
     *
     * @ORM\Column(name="permission", type="boolean", options={"default" : false})
     */
    private $permission = false;

    /**
     * @var array
     *
     * @Assert\Type(type="array")
     *
     * @ORM\Column(name="build_date", type="json", options={"jsonb" : true, "default" : "[]"})
     */
    private $buildDate = [];

    /**
     * @var null|int
     *
     * @Assert\Type(type="int")
     * @Assert\Choice(choices={
     *     Building::WITHOUT,
     *     Building::WITH,
     *     Building::WITH_AND_WITHOUT
     * }, message="Choose a valid facing type", strict=true)
     *
     * @ORM\Column(name="facing", type="smallint", nullable=true)
     */
    private $facing;

    /**
     * @var null|bool
     *
     * @Assert\Type(type="boolean")
     * @Assert\Choice(choices={
     *     Building::INSTALMENTS,
     *     Building::IPOTEKA
     * }, message="Choose a valid payment type", strict=true)
     *
     * @ORM\Column(name="payment_type", type="boolean", nullable=true)
     */
    private $paymentType;

    /**
     * @var Bank[]
     *
     * @ORM\ManyToMany(targetEntity="Bank", inversedBy="accreditated", cascade={"persist"})
     * @ORM\JoinTable(name="rlt_accreditated_buildings",
     *     joinColumns={@ORM\JoinColumn(name="building_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="bank_id", referencedColumnName="id")}
     * )
     */
    private $accreditation;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="ext_updated", type="string", length=255, nullable=true)
     */
    private $extUpdated;

    /**
     * @var array
     *
     * @Assert\Type(type="array")
     *
     * @ORM\Column(name="images", type="json", options={"jsonb" : true, "default" : "[]"})
     */
    private $images = [];

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="our_opinition", type="string", nullable=true)
     */
    private $ourOpinition;

    /**
     * @var News[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\News", mappedBy="building", cascade={"persist"})
     */
    private $news;

    /**
     * @var bool
     *
     * @Assert\Type(type="boolean")
     * @Assert\Choice(choices={
     *     Building::IN_PROCESS,
     *     Building::READY
     * }, message="Choose a valid payment type", strict=true)
     *
     * @ORM\Column(name="status", type="boolean", options={"default" : false})
     */
    private $status = false;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="parking", type="string", nullable=true)
     */
    private $parking;

    /**
     * @var int
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="price", type="string", nullable=true)
     */
    private $price;

    /**
     * @var int
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="price_per_m2", type="string", nullable=true)
     */
    private $pricePerM2;

    /**
     * @var Flat[]
     *
     * @ORM\Column(name="flats", type="flat", options={"default" : "[]", "jsonb" : true})
     */
    private $flats;

    /**
     * @var User
     * @Assert\Blank()
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\User", inversedBy="buildingsCreated", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="user_creator", referencedColumnName="id")
     */
    private $userCreator;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\User", inversedBy="buildingsUpdated", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="user_updater", referencedColumnName="id", nullable=true)
     */
    private $userUpdater;

    /**
     * @var \DateTime
     *
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     *
     * @ORM\Column(name="created_at", type="datetime", options={"default" = "now()"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     *
     * @ORM\Column(name="created_at", type="datetime", options={"default" = "now()"})
     */
    private $updatedAt;

    /**
     * Building constructor.
     */
    public function __construct()
    {
        $this->metro = new ArrayCollection();
        $this->accreditation = new ArrayCollection();
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
     *
     * @return Building
     */
    public function setId(int $id): Building
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
     * @return Building
     */
    public function setName(string $name): Building
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Distinct
     */
    public function getDistinct(): Distinct
    {
        return $this->distinct;
    }

    /**
     * @param Distinct $distinct
     *
     * @return Building
     */
    public function setDistinct(Distinct $distinct): Building
    {
        $this->distinct = $distinct;

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
     * @return Building
     */
    public function setExternalId(int $externalId): Building
    {
        $this->externalId = $externalId;

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
     *
     * @return Building
     */
    public function setMetro(array $metro): Building
    {
        $this->metro = $metro;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getClass(): ?int
    {
        return $this->class;
    }

    /**
     * @param null|int $class
     *
     * @return Building
     */
    public function setClass(?int $class): Building
    {
        $this->class = $class;

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
     * @return Building
     */
    public function setAddress(?string $address): Building
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getBuildType(): ?int
    {
        return $this->buildType;
    }

    /**
     * @param null|int $buildType
     *
     * @return Building
     */
    public function setBuildType(?int $buildType): Building
    {
        $this->buildType = $buildType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFloors(): ?string
    {
        return $this->floors;
    }

    /**
     * @param null|string $floors
     *
     * @return Building
     */
    public function setFloors(?string $floors): Building
    {
        $this->floors = $floors;

        return $this;
    }

    /**
     * @return Developer
     */
    public function getDeveloper(): Developer
    {
        return $this->developer;
    }

    /**
     * @param Developer $developer
     *
     * @return Building
     */
    public function setDeveloper(Developer $developer): Building
    {
        $this->developer = $developer;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function getContractType(): ?bool
    {
        return $this->contractType;
    }

    /**
     * @param null|bool $contractType
     *
     * @return Building
     */
    public function setContractType(?bool $contractType): Building
    {
        $this->contractType = $contractType;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFlatCount(): ?string
    {
        return $this->flatCount;
    }

    /**
     * @param null|string $flatCount
     *
     * @return Building
     */
    public function setFlatCount(?string $flatCount): Building
    {
        $this->flatCount = $flatCount;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPermission(): bool
    {
        return $this->permission;
    }

    /**
     * @param bool $permission
     *
     * @return Building
     */
    public function setPermission(bool $permission): Building
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * @return array
     */
    public function getBuildDate(): array
    {
        return $this->buildDate;
    }

    /**
     * @param array $buildDate
     *
     * @return Building
     */
    public function setBuildDate(array $buildDate): Building
    {
        $this->buildDate = $buildDate;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getFacing(): ?int
    {
        return $this->facing;
    }

    /**
     * @param null|int $facing
     *
     * @return Building
     */
    public function setFacing(?int $facing): Building
    {
        $this->facing = $facing;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function getPaymentType(): ?bool
    {
        return $this->paymentType;
    }

    /**
     * @param null|bool $paymentType
     *
     * @return Building
     */
    public function setPaymentType(?bool $paymentType): Building
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return Bank[]
     */
    public function getAccreditation(): array
    {
        return $this->accreditation;
    }

    /**
     * @param Bank[] $accreditation
     *
     * @return Building
     */
    public function setAccreditation(array $accreditation): Building
    {
        $this->accreditation = $accreditation;

        return $this;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     *
     * @return Building
     */
    public function setImages(array $images): Building
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getExtUpdated(): ?string
    {
        return $this->extUpdated;
    }

    /**
     * @param null|string $extUpdated
     *
     * @return Building
     */
    public function setExtUpdated(?string $extUpdated): Building
    {
        $this->extUpdated = $extUpdated;

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
     * @return Building
     */
    public function setDescription(?string $description): Building
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getOurOpinition(): ?string
    {
        return $this->ourOpinition;
    }

    /**
     * @param null|string $ourOpinition
     *
     * @return Building
     */
    public function setOurOpinition(?string $ourOpinition): Building
    {
        $this->ourOpinition = $ourOpinition;

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
     * @return Building
     */
    public function setNews(array $news): Building
    {
        $this->news = $news;

        return $this;
    }

    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @param bool $status
     *
     * @return Building
     */
    public function setStatus(bool $status): Building
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getParking(): ?string
    {
        return $this->parking;
    }

    /**
     * @param null|string $parking
     *
     * @return Building
     */
    public function setParking(?string $parking): Building
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     *
     * @return Building
     */
    public function setPrice(int $price): Building
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getPricePerM2(): int
    {
        return $this->pricePerM2;
    }

    /**
     * @param int $pricePerM2
     *
     * @return Building
     */
    public function setPricePerM2(int $pricePerM2): Building
    {
        $this->pricePerM2 = $pricePerM2;

        return $this;
    }

    /**
     * @return array
     */
    public function getFlats(): array
    {
        return $this->flats;
    }

    /**
     * @param array $flats
     *
     * @return Building
     */
    public function setFlats(array $flats): Building
    {
        $this->flats = $flats;

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
     * @return Building
     */
    public function setUserCreator(User $userCreator): Building
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
     * @return Building
     */
    public function setUserUpdater(?User $userUpdater): Building
    {
        $this->userUpdater = $userUpdater;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Building
     */
    public function setCreatedAt(\DateTime $createdAt): Building
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return Building
     */
    public function setUpdatedAt(\DateTime $updatedAt): Building
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
