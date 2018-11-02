<?php

namespace RltBundle\Entity\Model;

final class DeveloperDTO implements DTOInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var null|string
     */
    private $address;

    /**
     * @var null|string
     */
    private $phone;

    /**
     * @var null|string
     */
    private $email;

    /**
     * @var null|string
     */
    private $site;

    /**
     * @var null|string
     */
    private $created;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @var string
     */
    private $logo;

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
     * @return DeveloperDTO
     */
    public function setName(string $name): DeveloperDTO
    {
        $this->name = $name;

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
     * @return DeveloperDTO
     */
    public function setAddress(?string $address): DeveloperDTO
    {
        $this->address = $address;

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
     * @return DeveloperDTO
     */
    public function setPhone(?string $phone): DeveloperDTO
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     *
     * @return DeveloperDTO
     */
    public function setEmail(?string $email): DeveloperDTO
    {
        $this->email = $email;

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
     * @return DeveloperDTO
     */
    public function setSite(?string $site): DeveloperDTO
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCreated(): ?string
    {
        return $this->created;
    }

    /**
     * @param null|string $created
     *
     * @return DeveloperDTO
     */
    public function setCreated(?string $created): DeveloperDTO
    {
        $this->created = $created;

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
     * @return DeveloperDTO
     */
    public function setDescription(?string $description): DeveloperDTO
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     *
     * @return DeveloperDTO
     */
    public function setLogo(string $logo): DeveloperDTO
    {
        $this->logo = $logo;

        return $this;
    }
}
