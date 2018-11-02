<?php

namespace RltBundle\Entity\Model;

final class NewsDTO implements DTOInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $date;

    /**
     * @var array
     */
    private $images;

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $relatedEntities;

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
     * @return NewsDTO
     */
    public function setName(string $name): NewsDTO
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
     * @return NewsDTO
     */
    public function setTitle(string $title): NewsDTO
    {
        $this->title = $title;

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
     * @return NewsDTO
     */
    public function setDate(string $date): NewsDTO
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
     * @return NewsDTO
     */
    public function setImages(array $images): NewsDTO
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
     * @return NewsDTO
     */
    public function setText(string $text): NewsDTO
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return array
     */
    public function getRelatedEntities(): array
    {
        return $this->relatedEntities;
    }

    /**
     * @param array $relatedEntities
     *
     * @return NewsDTO
     */
    public function setRelatedEntities(array $relatedEntities): NewsDTO
    {
        $this->relatedEntities = $relatedEntities;

        return $this;
    }
}
