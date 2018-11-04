<?php

namespace RltBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * News.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "title"})
 *
 * @ORM\Table(name="rlt_news",
 *     indexes={
 *         @ORM\Index(name="rlt_news_name_idx", columns={"name"}),
 *         @ORM\Index(name="rlt_news_date_idx", columns={"date"}),
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
    private $name;

    /**
     * @var string
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
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="date", type="string", unique=true)
     */
    private $date;

    /**
     * @var array
     *
     * @ORM\Column(name="images", type="json_array", options={"jsonb" : true, "default" : "[]"})
     */
    private $images = [];

    /**
     * @var string
     *
     * @Assert\Type(type="string")
     *
     * @ORM\Column(name="text", type="string")
     */
    private $text;

    /**
     * @var null|Developer
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Developer", inversedBy="news")
     * @ORM\JoinColumn(name="developer_id", referencedColumnName="id", nullable=true)
     */
    private $developer;

    /**
     * @var null|Bank
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Bank", inversedBy="news")
     * @ORM\JoinColumn(name="bank_id", referencedColumnName="id", nullable=true)
     */
    private $bank;

    /**
     * @var Building
     *
     * @ORM\ManyToOne(targetEntity="RltBundle\Entity\Building", inversedBy="news")
     * @ORM\JoinColumn(name="building_id", referencedColumnName="id")
     */
    private $building;

    /**
     * @var User
     * @Assert\Blank()
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
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

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
     * @return News
     */
    public function setId(int $id): News
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
     * @return News
     */
    public function setName(string $name): News
    {
        $this->name = $name;

        return $this;
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
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     *
     * @return News
     */
    public function setDate(string $date): News
    {
        $this->date = $date;

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
     * @return News
     */
    public function setImages(array $images): News
    {
        $this->images = $images;

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
     * @return User
     */
    public function getUserCreator(): User
    {
        return $this->userCreator;
    }

    /**
     * @param User $userCreator
     */
    public function setUserCreator(User $userCreator): void
    {
        $this->userCreator = $userCreator;
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
    public function setUserUpdater(?User $userUpdater): void
    {
        $this->userUpdater = $userUpdater;
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
}
