<?php

namespace OfferBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use OfferBundle\Validator\Constraints as AftersaleAssert;

/**
 * OfferAftersale
 *
 * @ORM\Table(name="offer_aftersale")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferAftersaleRepository")
 *
 * @AftersaleAssert\Discount
 */
class OfferAftersale extends BaseOffer
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
     * @var OfferSubtype $subtype
     *
     * @ORM\ManyToOne(
     *     targetEntity="OfferSubtype",
     *     inversedBy="offerAftersales",
     *     fetch="EAGER"
     * )
     * @ORM\JoinColumn(
     *     name="subtype_id",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    protected $subtype;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="details", type="text")
     */
    protected $details;

    /**
     * @var float
     *
     * Assert done in entity annotation : AftersaleAssert\Discount
     * According to the subtype, this attribute can be empty or not
     *
     * This value is used for simple, double and triple discount.
     * It can be a price or a percent.
     *
     * @ORM\Column(name="discount_simple", type="float", nullable=true)
     */
    protected $discountSimple;

    /**
     * @var float
     *
     * Assert done in entity annotation : AftersaleAssert\Discount
     * According to the subtype, this attribute can be empty or not
     *
     * This value is used for double and triple discount.
     * It can be a price or a percent.
     *
     * @ORM\Column(name="discount_double", type="float", nullable=true)
     */
    protected $discountDouble;

    /**
     * @var float
     *
     * Assert done in entity annotation : AftersaleAssert\Discount
     * According to the subtype, this attribute can be empty or not
     *
     * This value is used for triple discount.
     * It can be a price or a percent.
     *
     * @ORM\Column(name="discount_triple", type="float", nullable=true)
     */
    protected $discountTriple;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToOne(
     *     targetEntity="OfferAftersaleTermsProperty",
     *     mappedBy="offer",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $termsProperties;

    /**
     * OfferAftersale constructor.
     * @param OfferSubtype $subtype
     */
    public function __construct(OfferSubtype $subtype)
    {
        parent::__construct();
        $this->subtype = $subtype;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subtype
     *
     * @param OfferSubtype $subtype
     *
     * @return OfferAftersale
     */
    public function setSubtype(OfferSubtype $subtype)
    {
        $this->subtype = $subtype;

        return $this;
    }

    /**
     * Get subtype
     *
     * @return OfferSubtype
     */
    public function getSubtype() : OfferSubtype
    {
        return $this->subtype;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return OfferAftersale
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set discountSimple
     *
     * @param float $discountSimple
     *
     * @return OfferAftersale
     */
    public function setDiscountSimple($discountSimple)
    {
        $this->discountSimple = $discountSimple;

        return $this;
    }

    /**
     * Get discountSimple
     *
     * @return float
     */
    public function getDiscountSimple()
    {
        return $this->discountSimple;
    }

    /**
     * Set discountDouble
     *
     * @param float $discountDouble
     *
     * @return OfferAftersale
     */
    public function setDiscountDouble($discountDouble)
    {
        $this->discountDouble = $discountDouble;

        return $this;
    }

    /**
     * Get discountDouble
     *
     * @return float
     */
    public function getDiscountDouble()
    {
        return $this->discountDouble;
    }

    /**
     * Set discountTriple
     *
     * @param float $discountTriple
     *
     * @return OfferAftersale
     */
    public function setDiscountTriple($discountTriple)
    {
        $this->discountTriple = $discountTriple;

        return $this;
    }

    /**
     * Get discountTriple
     *
     * @return float
     */
    public function getDiscountTriple()
    {
        return $this->discountTriple;
    }

    /**
     * @return OfferAftersale
     */
    public function setTermsProperty($termsProperty)
    {
        $this->termsProperties = $termsProperty;

        return $this;
    }

    /**
     * @return OfferAftersaleTermsProperty
     */
    public function getTermsProperty()
    {
        return $this->termsProperties;
    }
}
