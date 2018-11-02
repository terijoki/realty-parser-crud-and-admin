<?php

namespace RltBundle\Entity\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class BuildingDTO implements DTOInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var null|string
     */
    private $metro;

    /**
     * @var null|string
     */
    private $class;

    /**
     * @var null|string
     */
    private $address;

    /**
     * @var null|string
     */
    private $buildType;

    /**
     * @var null|string
     */
    private $floors;

    /**
     * @var string
     */
    private $developer;

    /**
     * @var string
     */
    private $developerLink;

    /**
     * @var null|string
     */
    private $contractType;

    /**
     * @var null|int
     */
    private $flatCount;

    /**
     * @var null|string
     */
    private $permission;

    /**
     * @var array
     */
    private $buildDate;

    /**
     * @var null|string
     */
    private $facing;

    /**
     * @var null|string
     */
    private $paymentType;

    /**
     * @var array
     */
    private $accreditation;

    /**
     * @var array
     */
    private $bankLinks;

    /**
     * @var array
     */
    private $images;

    /**
     * @var null|string
     */
    private $description;

    /**
     * @var null|string
     */
    private $ourOpinition;

    /**
     * @var null|bool
     */
    private $status;

    /**
     * @var null|string
     */
    private $parking;

    /**
     * @var null|string
     */
    private $price;

    /**
     * @var null|string
     */
    private $pricePerM2;

    /**
     * @var Flat[]
     */
    private $flats;

    /**
     * @var null|string
     */
    private $updated;

    /**
     * BuildingDTO constructor.
     */
    public function __construct()
    {
        $this->flats = new ArrayCollection();
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
     * @return BuildingDTO
     */
    public function setName(string $name): BuildingDTO
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMetro(): ?string
    {
        return $this->metro;
    }

    /**
     * @param null|string $metro
     *
     * @return BuildingDTO
     */
    public function setMetro(?string $metro): BuildingDTO
    {
        $this->metro = $metro;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @param null|string $class
     *
     * @return BuildingDTO
     */
    public function setClass(?string $class): BuildingDTO
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
     * @return BuildingDTO
     */
    public function setAddress(?string $address): BuildingDTO
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBuildType(): ?string
    {
        return $this->buildType;
    }

    /**
     * @param null|string $buildType
     *
     * @return BuildingDTO
     */
    public function setBuildType(?string $buildType): BuildingDTO
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
     * @return BuildingDTO
     */
    public function setFloors(?string $floors): BuildingDTO
    {
        $this->floors = $floors;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeveloper(): string
    {
        return $this->developer;
    }

    /**
     * @param string $developer
     *
     * @return BuildingDTO
     */
    public function setDeveloper(string $developer): BuildingDTO
    {
        $this->developer = $developer;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeveloperLink(): string
    {
        return $this->developerLink;
    }

    /**
     * @param string $developerLink
     *
     * @return BuildingDTO
     */
    public function setDeveloperLink(string $developerLink): BuildingDTO
    {
        $this->developerLink = $developerLink;

        return $this;
    }

    /**
     * @return array
     */
    public function getBankLinks(): array
    {
        return $this->bankLinks;
    }

    /**
     * @param array $bankLinks
     *
     * @return BuildingDTO
     */
    public function setBankLinks(array $bankLinks): BuildingDTO
    {
        $this->bankLinks = $bankLinks;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getContractType(): ?string
    {
        return $this->contractType;
    }

    /**
     * @param null|string $contractType
     *
     * @return BuildingDTO
     */
    public function setContractType(?string $contractType): BuildingDTO
    {
        $this->contractType = $contractType;

        return $this;
    }

    /**
     * @return null|int
     */
    public function getFlatCount(): ?int
    {
        return $this->flatCount;
    }

    /**
     * @param null|int $flatCount
     *
     * @return BuildingDTO
     */
    public function setFlatCount(?int $flatCount): BuildingDTO
    {
        $this->flatCount = $flatCount;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPermission(): ?string
    {
        return $this->permission;
    }

    /**
     * @param null|string $permission
     *
     * @return BuildingDTO
     */
    public function setPermission(?string $permission): BuildingDTO
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
     * @return BuildingDTO
     */
    public function setBuildDate(array $buildDate): BuildingDTO
    {
        $this->buildDate = $buildDate;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getFacing(): ?string
    {
        return $this->facing;
    }

    /**
     * @param null|string $facing
     *
     * @return BuildingDTO
     */
    public function setFacing(?string $facing): BuildingDTO
    {
        $this->facing = $facing;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    /**
     * @param null|string $paymentType
     *
     * @return BuildingDTO
     */
    public function setPaymentType(?string $paymentType): BuildingDTO
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * @return array
     */
    public function getAccreditation(): array
    {
        return $this->accreditation;
    }

    /**
     * @param array $accreditation
     *
     * @return BuildingDTO
     */
    public function setAccreditation(array $accreditation): BuildingDTO
    {
        $this->accreditation = $accreditation;

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
     * @return BuildingDTO
     */
    public function setImages(array $images): BuildingDTO
    {
        $this->images = $images;

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
     * @return BuildingDTO
     */
    public function setDescription(?string $description): BuildingDTO
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
     * @return BuildingDTO
     */
    public function setOurOpinition(?string $ourOpinition): BuildingDTO
    {
        $this->ourOpinition = $ourOpinition;

        return $this;
    }

    /**
     * @return null|bool
     */
    public function getStatus(): ?bool
    {
        return $this->status;
    }

    /**
     * @param null|bool $status
     *
     * @return BuildingDTO
     */
    public function setStatus(?bool $status): BuildingDTO
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
     * @return BuildingDTO
     */
    public function setParking(?string $parking): BuildingDTO
    {
        $this->parking = $parking;

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
     * @return BuildingDTO
     */
    public function setPrice(?string $price): BuildingDTO
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
     * @return BuildingDTO
     */
    public function setPricePerM2(?string $pricePerM2): BuildingDTO
    {
        $this->pricePerM2 = $pricePerM2;

        return $this;
    }

    /**
     * @return Collection|Flat[]
     */
    public function getFlats()
    {
        return $this->flats;
    }

    /**
     * @param Flat $flat
     *
     * @return BuildingDTO
     */
    public function addFlat(Flat $flat)
    {
        $this->flats[] = $flat;

        return $this;
    }

    /**
     * @param Flat[] $flats
     *
     * @return BuildingDTO
     */
    public function setFlats(array $flats): BuildingDTO
    {
        $this->flats = $flats;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getUpdated(): ?string
    {
        return $this->updated;
    }

    /**
     * @param null|string $updated
     *
     * @return BuildingDTO
     */
    public function setUpdated(?string $updated): BuildingDTO
    {
        $this->updated = $updated;

        return $this;
    }
}
