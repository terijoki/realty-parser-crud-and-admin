<?php

namespace RltBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\Group as BaseGroup;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Serializer\ExclusionPolicy("all")
 * @Serializer\AccessorOrder("custom", custom={"id"})
 *
 * @ORM\Entity
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
    public const DEFAULT_GROUP = 'custom';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var User[]
     *
     * @ORM\ManyToMany(targetEntity="RltBundle\Entity\User", mappedBy="groups", fetch="EXTRA_LAZY")
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
     * @param User $user
     *
     * @return Group
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;

        return $this;
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
