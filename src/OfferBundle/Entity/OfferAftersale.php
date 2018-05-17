<?php

namespace OfferBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use OfferBundle\Validator\Constraints as AftersaleAssert;
use Symfony\Component\Serializer\Annotation\Groups;

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
     *
     * @Groups({"rest", "myaudi"})
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
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $subtype;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="details", type="text")
     *
     * @Groups({"rest", "myaudi"})
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
     *
     * @Groups({"rest", "myaudi"})
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
     *
     * @Groups({"rest", "myaudi"})
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
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $discountTriple;

    /**
     * @var OfferAftersaleTermsProperty
     *
     * @ORM\OneToOne(
     *     targetEntity="OfferAftersaleTermsProperty",
     *     mappedBy="offer",
     *     cascade={"persist", "remove"}
     * )
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $termsProperty;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="OfferAftersaleMyaudiUser",
     *     mappedBy="offer",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $myaudiUsers;

    /**
     * OfferAftersale constructor.
     * @param OfferSubtype $subtype
     */
    public function __construct(OfferSubtype $subtype)
    {
        parent::__construct();
        $this->subtype = $subtype;
        $this->myaudiUsers = new ArrayCollection();
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
     * @param OfferAftersaleTermsProperty $termsProperty
     * @return OfferAftersale
     */
    public function setTermsProperty($termsProperty)
    {
        $this->termsProperty = $termsProperty;

        return $this;
    }

    /**
     * @return OfferAftersaleTermsProperty
     */
    public function getTermsProperty()
    {
        return $this->termsProperty;
    }

    /**
     * @param ArrayCollection $myaudiUsers
     *
     * @return OfferAftersale
     */
    public function setMyaudiUsers(ArrayCollection $myaudiUsers)
    {
        $this->myaudiUsers = $myaudiUsers;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMyaudiUsers()
    {
        return $this->myaudiUsers;
    }
}
