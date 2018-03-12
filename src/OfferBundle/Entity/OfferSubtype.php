<?php

namespace OfferBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Subtype
 *
 * @ORM\Table(name="offer_subtype")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferSubtypeRepository")
 */
class OfferSubtype
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var int
     *
     * @ORM\Column(name="rank", type="integer")
     */
    protected $rank;

    /**
     * @var OfferType
     *
     * @ORM\ManyToOne(
     *     targetEntity="OfferType",
     *     inversedBy="subtypes"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $type;

    /**
     * @var OfferFormType
     *
     * @ORM\ManyToOne(
     *     targetEntity="OfferFormType",
     *     inversedBy="subtypes"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $formType;

    /**
     * @var string
     *
     * @ORM\Column(name="terms", type="text")
     */
    protected $terms;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="OfferAftersale",
     *     mappedBy="subtype",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $offerAftersales;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="OfferSale",
     *     mappedBy="subtype",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $offerSales;


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
     * Set name
     *
     * @param string $name
     *
     * @return OfferSubtype
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
     * Set rank
     *
     * @param integer $rank
     *
     * @return OfferSubtype
     */
    public function setRank(int $rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return int
     */
    public function getRank() : int
    {
        return $this->rank;
    }

    /**
     * Set type
     *
     * @param OfferType $type
     *
     * @return OfferSubtype
     */
    public function setType(OfferType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return OfferType
     */
    public function getType() : OfferType
    {
        return $this->type;
    }

    /**
     * Set formType
     *
     * @param OfferFormType $formType
     *
     * @return OfferSubtype
     */
    public function setFormType(OfferFormType $formType)
    {
        $this->formType = $formType;

        return $this;
    }

    /**
     * Get formType
     *
     * @return OfferFormType
     */
    public function getFormType() : OfferFormType
    {
        return $this->formType;
    }

    /**
     * Set terms
     *
     * @param string $terms
     *
     * @return OfferSubtype
     */
    public function setTerms(string $terms)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get terms
     *
     * @return string
     */
    public function getTerms() : string
    {
        return $this->terms;
    }
}

