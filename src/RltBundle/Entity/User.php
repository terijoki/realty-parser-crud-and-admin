<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Serializer\AccessorOrder("custom", custom={"id", "name", "createdAt", "updatedAt"})
 *
 * @ORM\Table(name="rlt_users")
 * @ORM\Entity(repositoryClass="RltBundle\Repository\UserRepository")
 * @UniqueEntity(
 *     fields={"email"},
 *     errorPath="email"
 * )
 * @UniqueEntity(
 *     fields={"username"},
 *     errorPath="username"
 * )
 */
class User extends BaseUser
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_MODERATOR = 'ROLE_MODERATOR';
    public const ROLE_USER = 'ROLE_USER';

    /**
     * @var int
     *
     * @Serializer\Expose()
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var Group[]
     *
     * @ORM\ManyToMany(targetEntity="RltBundle\Entity\Group", inversedBy="users", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="rlt_users_user_groups",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $password;

    /**
     * @var Building[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Building", mappedBy="user")
     */
    private $buildings;

    /**
     * @var Developer[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Developer", mappedBy="user")
     */
    private $developers;

    /**
     * @var Bank[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Bank", mappedBy="user")
     */
    private $banks;

    /**
     * @var News[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\News", mappedBy="user")
     */
    private $news;

    /**
     * @var \DateTime
     *
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     *
     * @ORM\Column(name="created_at", type="datetime", options={"default" = "now()"})
     */
    private $createdAt;

    /**
     * @var null|\DateTime
     *
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     *
     * @ORM\Column(name="updated_at", type="datetime", options={"default" = "now()"})
     */
    private $updatedAt;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->groups = new ArrayCollection();
        $this->buildings = new ArrayCollection();
        $this->developers = new ArrayCollection();
        $this->banks = new ArrayCollection();
        $this->news = new ArrayCollection();
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
     * @return User
     */
    public function setBuildings(array $buildings): User
    {
        $this->buildings = $buildings;
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
     * @return User
     */
    public function setBanks(array $banks): User
    {
        $this->banks = $banks;
        return $this;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Group[]
     */
    public function getGroups(): array
    {
        return $this->groups;
    }

    /**
     * @param Group[] $groups
     * @return User
     */
    public function setGroups(array $groups): User
    {
        $this->groups = $groups;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
     * @return User
     */
    public function setDevelopers(array $developers): User
    {
        $this->developers = $developers;
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
     * @return User
     */
    public function setNews(array $news): User
    {
        $this->news = $news;
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
     * @return User
     */
    public function setCreatedAt(\DateTime $createdAt): User
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime|null $updatedAt
     * @return User
     */
    public function setUpdatedAt(?\DateTime $updatedAt): User
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
