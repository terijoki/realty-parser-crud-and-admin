<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use RltBundle\Entity\Files\BuildingFiles;
use RltBundle\Entity\Model\Flat;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Building.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "name"})
 *
 * @ORM\Table(name="rlt_buildings",
 *     indexes={
 *         @ORM\Index(name="rlt_buildings_name_idx", columns={"name"}),
 *         @ORM\Index(name="rlt_buildings_district_idx", columns={"district_id"}),
 *         @ORM\Index(name="rlt_buildings_class_idx", columns={"class"}),
 *         @ORM\Index(name="rlt_buildings_build_type_idx", columns={"build_type"}),
 *         @ORM\Index(name="rlt_buildings_developers_idx", columns={"developer_id"}),
 *         @ORM\Index(name="rlt_buildings_facing_idx", columns={"facing"}),
 *         @ORM\Index(name="rlt_buildings_status_idx", columns={"status"}),
 *         @ORM\Index(name="rlt_buildings_payment_type_idx", columns={"payment_type"}),
 *         @ORM\Index(name="rlt_buildings_priceM2_idx", columns={"price_per_m2"}),
 *     }))
 *     @ORM\Entity(repositoryClass="RltBundle\Repository\BuildingRepository")
 */
class Building implements EntityInterface
{
    /**
     * Realty classes.
     */
    public const OTHER_CLASS = 0;
    public const ELITE = 1;
    public const BUSINESS = 2;
    public const COMFORT = 3;
    public const ECONOM = 4;
    public const CLASSES = [
        self::OTHER_CLASS => 'Другое',
        self::ELITE => 'Элитное жилье',
        self::BUSINESS => 'Бизнес-класс',
        self::COMFORT => 'Комфорт-класс',
        self::ECONOM => 'Эконом-класс',
    ];

    /**
     * Realty types.
     */
    public const OTHER_TYPE = 0;
    public const MONOLIT = 1;
    public const PANEL = 2;
    public const BRICK_MONOLIT = 3;
    public const CARCASS_MONOLIT = 4;
    public const BRICK = 5;
    public const TYPES = [
        self::OTHER_TYPE => 'Другое',
        self::MONOLIT => 'Монолитный',
        self::PANEL => 'Панельный',
        self::BRICK_MONOLIT => 'Кирпично-монолитный',
        self::CARCASS_MONOLIT => 'Каркасно-монолитный',
        self::BRICK => 'Кирпичный',
    ];

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
    public const FACING_TYPES = [
        self::WITHOUT => 'Без отделки',
        self::WITH => 'С отделкой',
        self::WITH_AND_WITHOUT => 'С отделкой и без',
    ];

    /**
     * Payment types.
     */
    public const INSTALMENTS = 0;
    public const IPOTEKA = 1;
    public const ANY = 2;
    public const PAYMENT_TYPES = [
        self::INSTALMENTS => 'Рассрочка',
        self::IPOTEKA => 'Ипотека',
        self::ANY => 'Ипотека и рассрочка',
    ];

    /**
     * Status.
     */
    public const IN_PROCESS = false;
    public const READY = true;

    public static $monthes = [
        'Января' => 1,
        'Февраля' => 2,
        'Марта' => 3,
        'Апреля' => 4,
        'Мая' => 5,
        'Июня' => 6,
        'Июля' => 7,
        'Августа' => 8,
        'Сентября' => 9,
        'Октября' => 10,
        'Ноября' => 11,
        'Декабря' => 12,
    ];

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
     * @var District
     *
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="District", cascade={"persist"})
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id", nullable=false)
     */
    private $district;

    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     *
     * @ORM\Column(name="external_id", type="integer", unique=true)
     */
    private $externalId;

    /**
     * @var null|Metro[]
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
     * @Assert\Type(type="integer")
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
     * @Assert\Type(type="integer")
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
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Developer", fetch="EXTRA_LAZY", inversedBy="buildings")
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
     * @Assert\Type(type="integer")
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
     * @var null|int
     *
     * @Assert\Type(type="boolean")
     * @Assert\Choice(choices={
     *     Building::INSTALMENTS,
     *     Building::IPOTEKA,
     *     Building::ANY,
     * }, message="Choose a valid payment type", strict=true)
     *
     * @ORM\Column(name="payment_type", type="boolean", nullable=true)
     */
    private $paymentType;

    /**
     * @var Bank[]
     *
     * @ORM\ManyToMany(targetEntity="Bank", inversedBy="accreditated", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinTable(name="rlt_accreditated_buildings",
     *     joinColumns={@ORM\JoinColumn(name="building_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="bank_id", referencedColumnName="id")}
     * )
     */
    private $accreditation;

    /**
     * @var ArrayCollection|BuildingFiles[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Files\BuildingFiles", mappedBy="entity", fetch="EAGER", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="our_opinition", type="text", nullable=true)
     */
    private $ourOpinition;

    /**
     * @var News[]
     *
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\News", mappedBy="building", fetch="EXTRA_LAZY", cascade={"persist"})
     */
    private $news;

    /**
     * @var bool
     *
     * @Assert\Type(type="boolean")
     * @Assert\Choice(choices={
     *     Building::IN_PROCESS,
     *     Building::READY
     * }, message="Choose a valid status", strict=true)
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="parking", type="string", nullable=true)
     */
    private $parking;

    /**
     * @var \DateTime
     *
     * @Assert\Type(type="DateTime")
     *
     * @ORM\Column(name="external_updated", type="datetime", nullable=true)
     */
    private $externalUpdated;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="price", type="string", nullable=true)
     */
    private $price;

    /**
     * @var null|string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="price_per_m2", type="string", nullable=true)
     */
    private $pricePerM2;

    /**
     * @var Flat[]
     *
     * @ORM\Column(name="flats", type="flats_sorted", options={"default" : "[]", "jsonb" : true})
     */
    private $flats;

    /**
     * @var City
     * @Assert\Blank()
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\City", inversedBy="buildings", fetch="EXTRA_LAZY", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @var User
     * @Assert\Blank()
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\User", inversedBy="buildingsCreated", fetch="EXTRA_LAZY", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="user_creator", referencedColumnName="id")
     */
    private $userCreator;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\User", inversedBy="buildingsUpdated", fetch="EXTRA_LAZY", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="user_updater", referencedColumnName="id", nullable=true)
     */
    private $userUpdater;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     *
     * @ORM\Column(name="created_at", type="datetime", options={"default" = "now()"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default" = "now()"})
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
        $this->images = new ArrayCollection();
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
     * @return District
     */
    public function getDistrict(): District
    {
        return $this->district;
    }

    /**
     * @param District|null $district
     *
     * @return Building
     */
    public function setDistrict(?District $district): Building
    {
        $this->district = $district;

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
     * @return null|Metro[]
     */
    public function getMetro(): ?array
    {
        return $this->metro;
    }

    /**
     * @param null|Collection|Metro[] $metro
     *
     * @return Building
     */
    public function setMetro($metro): Building
    {
        foreach ($metro as $item) {
            $this->addMetro($item);
        }

        return $this;
    }

    /**
     * @param null|Metro $metro
     *
     * @return Building
     */
    public function addMetro(?Metro $metro)
    {
        $this->metro[] = $metro;

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
     * @return null|int
     */
    public function getPaymentType(): ?int
    {
        return $this->paymentType;
    }

    /**
     * @param null|int $paymentType
     *
     * @return Building
     */
    public function setPaymentType(?int $paymentType): Building
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
        foreach ($accreditation as $item) {
            $this->addAccreditation($item);
        }

        return $this;
    }

    /**
     * @param Bank|Collection $bank
     *
     * @return Building
     */
    public function addAccreditation($bank)
    {
        $this->accreditation[] = $bank;

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
     * @return \DateTime
     */
    public function getExternalUpdated(): \DateTime
    {
        return $this->externalUpdated;
    }

    /**
     * @param \DateTime $externalUpdated
     *
     * @return Building
     */
    public function setExternalUpdated(?\DateTime $externalUpdated): Building
    {
        $this->externalUpdated = $externalUpdated;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param null|string $price
     *
     * @return Building
     */
    public function setPrice(?string $price): Building
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPricePerM2(): ?string
    {
        return $this->pricePerM2;
    }

    /**
     * @param null|string $pricePerM2
     *
     * @return Building
     */
    public function setPricePerM2(?string $pricePerM2): Building
    {
        $this->pricePerM2 = $pricePerM2;

        return $this;
    }

    /**
     * @return Collection|Flat[]
     */
    public function getFlats(): Collection
    {
        return $this->flats;
    }

    /**
     * @param Flat $flat
     *
     * @return Building
     */
    public function addFlat(Flat $flat)
    {
        $this->flats[] = $flat;

        return $this;
    }

    /**
     * @param Collection $flats
     *
     * @return Building
     */
    public function setFlats($flats): Building
    {
        foreach ($flats as $flat) {
            $this->addFlat($flat);
        }

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
     * @return Building
     */
    public function setCity(City $city): Building
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
    /**
     * @return string
     */
    public function getDeveloperName()
    {
        return $this->developer ? $this->developer->getName() : '';
    }

    /**
     * @return string
     */
    public function getDistrictName()
    {
        return $this->district ? $this->district->getName() : '';
    }
}
