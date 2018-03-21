<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OfferBundle\OfferBundle;
use Symfony\Component\Validator\Constraints as Assert;
use OfferBundle\Validator\Constraints as AftersaleAssert;
use OfferBundle\Entity\OfferSubtype;

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
    public function __construct(OfferSubtype $subtype)
    {
        parent::__construct();
        $this->subtype = $subtype;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var OfferSubtype
     *
     * @ORM\ManyToOne(targetEntity="OfferSubtype", inversedBy="offerAftersales")
     * @ORM\JoinColumn(name="subtype_id", referencedColumnName="id", nullable=false)
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
     *
     * @ORM\Column(name="discount_1", type="float", nullable=true)
     */
    protected $discount1;

    /**
     * @var float
     *
     * Assert done in entity annotation : AftersaleAssert\Discount
     *
     * @ORM\Column(name="discount_2", type="float", nullable=true)
     */
    protected $discount2;

    /**
     * @var float
     *
     * Assert done in entity annotation : AftersaleAssert\Discount
     *
     * @ORM\Column(name="discount_3", type="float", nullable=true)
     */
    protected $discount3;

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
     * Set discount1
     *
     * @param float $discount1
     *
     * @return OfferAftersale
     */
    public function setDiscount1($discount1)
    {
        $this->discount1 = $discount1;

        return $this;
    }

    /**
     * Get discount1
     *
     * @return float
     */
    public function getDiscount1()
    {
        return $this->discount1;
    }

    /**
     * Set discount2
     *
     * @param float $discount2
     *
     * @return OfferAftersale
     */
    public function setDiscount2($discount2)
    {
        $this->discount2 = $discount2;

        return $this;
    }

    /**
     * Get discount2
     *
     * @return float
     */
    public function getDiscount2()
    {
        return $this->discount2;
    }

    /**
     * Set discount3
     *
     * @param float $discount3
     *
     * @return OfferAftersale
     */
    public function setDiscount3($discount3)
    {
        $this->discount3 = $discount3;

        return $this;
    }

    /**
     * Get discount3
     *
     * @return float
     */
    public function getDiscount3()
    {
        return $this->discount3;
    }
}

