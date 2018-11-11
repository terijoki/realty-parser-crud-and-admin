<?php

namespace RltBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
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

    public const ADMIN = 'admin';
    public const PARSER = 'parser';
    public const MODERATOR = 'moderator';
    public const CUSTOM = 'custom';

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
     * @Assert\NotBlank()
     *
     * @var string
     */
    protected $password;

    /**
     * @var Group[]
     *
     * @Serializer\Groups({"getUser"})
     *
     * @ORM\ManyToMany(targetEntity="RltBundle\Entity\Group", inversedBy="users", fetch="EXTRA_LAZY")
     * @ORM\JoinTable(name="rlt_users_user_groups",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @var Building[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Building", fetch="EXTRA_LAZY", mappedBy="userCreator")
     */
    private $buildingsCreated;

    /**
     * @var Building[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Building", fetch="EXTRA_LAZY", mappedBy="userUpdater")
     */
    private $buildingsUpdated;

    /**
     * @var Developer[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Developer", fetch="EXTRA_LAZY", mappedBy="userCreator")
     */
    private $developersCreated;

    /**
     * @var Developer[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Developer", fetch="EXTRA_LAZY", mappedBy="userUpdater")
     */
    private $developersUpdated;

    /**
     * @var Bank[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Bank", fetch="EXTRA_LAZY", mappedBy="userCreator")
     */
    private $banksCreated;

    /**
     * @var Bank[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\Bank", fetch="EXTRA_LAZY", mappedBy="userUpdater")
     */
    private $banksUpdated;

    /**
     * @var News[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\News", fetch="EXTRA_LAZY", mappedBy="userCreator")
     */
    private $newsCreated;

    /**
     * @var News[]
     *
     * @ORM\OneToMany(targetEntity="RltBundle\Entity\News", fetch="EXTRA_LAZY", mappedBy="userUpdater")
     */
    private $newsUpadted;

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
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
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
     * @param int $id
     *
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;

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
     * @return Building[]
     */
    public function getBuildingsCreated(): array
    {
        return $this->buildingsCreated;
    }

    /**
     * @param Building[] $buildingsCreated
     *
     * @return User
     */
    public function setBuildingsCreated(array $buildingsCreated): User
    {
        $this->buildingsCreated = $buildingsCreated;

        return $this;
    }

    /**
     * @return Building[]
     */
    public function getBuildingsUpdated(): array
    {
        return $this->buildingsUpdated;
    }

    /**
     * @param Building[] $buildingsUpdated
     *
     * @return User
     */
    public function setBuildingsUpdated(array $buildingsUpdated): User
    {
        $this->buildingsUpdated = $buildingsUpdated;

        return $this;
    }

    /**
     * @return Developer[]
     */
    public function getDevelopersCreated(): array
    {
        return $this->developersCreated;
    }

    /**
     * @param Developer[] $developersCreated
     *
     * @return User
     */
    public function setDevelopersCreated(array $developersCreated): User
    {
        $this->developersCreated = $developersCreated;

        return $this;
    }

    /**
     * @return Developer[]
     */
    public function getDevelopersUpdated(): array
    {
        return $this->developersUpdated;
    }

    /**
     * @param Developer[] $developersUpdated
     *
     * @return User
     */
    public function setDevelopersUpdated(array $developersUpdated): User
    {
        $this->developersUpdated = $developersUpdated;

        return $this;
    }

    /**
     * @return Bank[]
     */
    public function getBanksCreated(): array
    {
        return $this->banksCreated;
    }

    /**
     * @param Bank[] $banksCreated
     *
     * @return User
     */
    public function setBanksCreated(array $banksCreated): User
    {
        $this->banksCreated = $banksCreated;

        return $this;
    }

    /**
     * @return Bank[]
     */
    public function getBanksUpdated(): array
    {
        return $this->banksUpdated;
    }

    /**
     * @param Bank[] $banksUpdated
     *
     * @return User
     */
    public function setBanksUpdated(array $banksUpdated): User
    {
        $this->banksUpdated = $banksUpdated;

        return $this;
    }

    /**
     * @return News[]
     */
    public function getNewsCreated(): array
    {
        return $this->newsCreated;
    }

    /**
     * @param News[] $newsCreated
     *
     * @return User
     */
    public function setNewsCreated(array $newsCreated): User
    {
        $this->newsCreated = $newsCreated;

        return $this;
    }

    /**
     * @return News[]
     */
    public function getNewsUpadted(): array
    {
        return $this->newsUpadted;
    }

    /**
     * @param News[] $newsUpadted
     *
     * @return User
     */
    public function setNewsUpadted(array $newsUpadted): User
    {
        $this->newsUpadted = $newsUpadted;

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
     * @return User
     */
    public function setCreatedAt(\DateTime $createdAt): User
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return null|\DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param null|\DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt(?\DateTime $updatedAt): User
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
