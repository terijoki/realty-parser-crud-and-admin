<?php

namespace RltBundle\Entity\Model;

final class BankDTO implements DTOInterface
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
     * @return BankDTO
     */
    public function setName(string $name): BankDTO
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
     * @return BankDTO
     */
    public function setAddress(?string $address): BankDTO
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
     * @return BankDTO
     */
    public function setPhone(?string $phone): BankDTO
    {
        $this->phone = $phone;

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
     * @return BankDTO
     */
    public function setSite(?string $site): BankDTO
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
     * @return BankDTO
     */
    public function setCreated(?string $created): BankDTO
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
     * @return BankDTO
     */
    public function setDescription(?string $description): BankDTO
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
     * @return BankDTO
     */
    public function setLogo(string $logo): BankDTO
    {
        $this->logo = $logo;

        return $this;
    }
}
