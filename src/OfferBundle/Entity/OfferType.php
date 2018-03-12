<?php

namespace OfferBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OfferType
 *
 * @ORM\Table(name="offer_type")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferTypeRepository")
 */
class OfferType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(
     *     name="category",
     *     type="string",
     *     length=255,
     *     columnDefinition="ENUM('AFTERSALE', 'SECONDHANDCAR', 'NEWCAR')"
     * )
     */
    protected $category;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255, nullable=true)
     */
    protected $subtitle;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="OfferSubtype",
     *     mappedBy="type",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $subtypes;


    /**
     * Get id
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return OfferType
     */
    public function setCategory(string $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory() : string
    {
        return $this->category;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return OfferType
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return OfferType
     */
    public function setSubtitle(string $subtitle = null)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle() : string
    {
        return $this->subtitle;
    }

    /**
     * @return ArrayCollection
     */
    public function getSubtypes(): ArrayCollection
    {
        return $this->subtypes;
    }
}

