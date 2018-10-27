<?php

namespace RltBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;
use FOS\UserBundle\Model\Group as BaseGroup;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Serializer\AccessorOrder("custom", custom={"id"})
 *
 * @ORM\Entity(repositoryClass="RltBundle\Repository\GroupRepository")
 * @ORM\Table(name="rlt_user_groups")
 * @UniqueEntity(
 *     fields={"name"},
 *     errorPath="name"
 * )
 */
class Group extends BaseGroup
{
    public const GROUP_ADMIN = 'admin';
    public const GROUP_MODERATOR = 'moderator';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var user[]
     *
     * Many Groups have Many Users
     * @ManyToMany(targetEntity="RltBundle\Entity\User", mappedBy="groups", fetch="EXTRA_LAZY")
     */
    protected $users;

    public function __construct($name = null, $roles = [])
    {
        parent::__construct($name, $roles);
    }

    /**
     * @return User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min="3")
     * @Assert\Length(max="180")
     *
     * @return string
     */
    public function getName()
    {
        return parent::getName();
    }

    /**
     * Add user.
     *
     * @param \RltBundle\Entity\User $user
     *
     * @return Group
     */
    public function addUser(\RltBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \RltBundle\Entity\User $user
     */
    public function removeUser(\RltBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * @param int $id
     *
     * @return Group
     */
    public function setId(int $id): Group
    {
        $this->id = $id;

        return $this;
    }
}
