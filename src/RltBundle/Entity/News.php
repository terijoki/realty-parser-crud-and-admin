<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use RltBundle\Entity\Files\NewsFiles;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * News.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "title"})
 *
 * @ORM\Table(name="rlt_news",
 *     indexes={
 *         @ORM\Index(name="rlt_news_name_idx", columns={"title"}),
 *         @ORM\Index(name="rlt_news_text_idx", columns={"text"}),
 *         @ORM\Index(name="rlt_news_developers_idx", columns={"developer_id"}),
 *         @ORM\Index(name="rlt_news_buildings_idx", columns={"building_id"}),
 *         @ORM\Index(name="rlt_news_banks_idx", columns={"bank_id"}),
 *     }))
 *     @ORM\Entity(repositoryClass="RltBundle\Repository\NewsRepository")
 */
class News implements EntityInterface
{
    /**
     * @var int
     *
     * @Serializer\Groups({"getShortNews"})
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\Groups({"getShortNews"})
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="title", type="string", unique=true)
     */
    private $title;

    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     *
     * @ORM\Column(name="external_id", type="smallint", unique=true)
     */
    private $externalId;

    /**
     * @var ArrayCollection|NewsFiles[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Files\NewsFiles", mappedBy="entity", fetch="EAGER", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @var string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var null|Developer
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Developer", fetch="EXTRA_LAZY", inversedBy="news")
     * @ORM\JoinColumn(name="developer_id", referencedColumnName="id", nullable=true)
     */
    private $developer;

    /**
     * @var null|Bank
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Bank", fetch="EXTRA_LAZY", inversedBy="news")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="id", nullable=true)
     */
    private $bank;

    /**
     * @var Building
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Building", fetch="EXTRA_LAZY", inversedBy="news")
     * @ORM\JoinColumn(name="building_id", referencedColumnName="id")
     */
    private $building;

    /**
     * @var City
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\City", inversedBy="news", fetch="EXTRA_LAZY", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     */
    private $city;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\User", inversedBy="newsCreated", cascade={"persist"})
     *
     * @ORM\JoinColumn(name="user_creator", referencedColumnName="id")
     */
    private $userCreator;

    /**
     * @var null|User
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\User", inversedBy="newsUpdated", cascade={"persist"})
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
     * @Serializer\Groups({"getShortNews"})
     *
     * @ORM\Column(name="created_at", type="datetime", options={"default" = "now()"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     * @Serializer\Groups({"getShortNews"})
     *
     * @Gedmo\Timestampable(on="update")
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * NewsConstructor constructor.
     */
    public function __construct()
    {
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return News
     */
    public function setTitle(string $title): News
    {
        $this->title = $title;

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
     * @return News
     */
    public function setExternalId(int $externalId): News
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return News
     */
    public function setText(string $text): News
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return null|Developer
     */
    public function getDeveloper(): ?Developer
    {
        return $this->developer;
    }

    /**
     * @param null|Developer $developer
     *
     * @return News
     */
    public function setDeveloper(?Developer $developer): News
    {
        $this->developer = $developer;

        return $this;
    }

    /**
     * @return null|Bank
     */
    public function getBank(): ?Bank
    {
        return $this->bank;
    }

    /**
     * @param null|Bank $bank
     *
     * @return News
     */
    public function setBank(?Bank $bank): News
    {
        $this->bank = $bank;

        return $this;
    }

    /**
     * @return Building
     */
    public function getBuilding(): Building
    {
        return $this->building;
    }

    /**
     * @param Building $building
     *
     * @return News
     */
    public function setBuilding(Building $building): News
    {
        $this->building = $building;

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
     * @return News
     */
    public function setCity(City $city): News
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
     */
    public function setUserCreator(User $userCreator): News
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
     */
    public function setUserUpdater(?User $userUpdater): News
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
     * @return News
     */
    public function setCreatedAt(\DateTime $createdAt): News
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
     * @return News
     */
    public function setUpdatedAt(\DateTime $updatedAt): News
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getBankName()
    {
        return $this->bank ? $this->bank->getName() : '';
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
    public function getBuildingName()
    {
        return $this->building ? $this->building->getName() : '';
    }
}
