<?php

namespace RltBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * News.
 *
 * @Serializer\AccessorOrder("custom", custom={"id", "title"})
 *
 * @ORM\Table(name="rlt_news")
 * @ORM\Entity(repositoryClass="RltBundle\Repository\NewsRepository")
 */
class News
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
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
     * @ORM\Column(name="description", type="string", unique=true)
     */
    private $description;

    /**
     * @var array
     *
     * @ORM\Column(name="images", type="json_array", options={"jsonb" : true, "default" : "[]"})
     */
    private $text = [];

    /**
     * @var ?
     */
    private $tags;

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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
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
     * @return News
     */
    public function setExternalId(int $externalId): News
    {
        $this->externalId = $externalId;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return News
     */
    public function setDescription(string $description): News
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getText(): array
    {
        return $this->text;
    }

    /**
     * @param array $text
     * @return News
     */
    public function setText(array $text): News
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param mixed $tags
     * @return News
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
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
     * @return News
     */
    public function setBuilding(Building $building): News
    {
        $this->building = $building;
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
     * @return News
     */
    public function setUpdatedAt(\DateTime $updatedAt): News
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}