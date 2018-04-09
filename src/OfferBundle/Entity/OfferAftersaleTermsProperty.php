<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OfferAftersaleTermsProperty
 *
 * @ORM\Table(name="offer_aftersale_terms_property")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferAftersaleTermsPropertyRepository")
 */
class OfferAftersaleTermsProperty
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
     * @var OfferAftersale
     *
     * @ORM\OneToOne(
     *     targetEntity="OfferAftersale",
     *     inversedBy="termsProperties"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $offer;

    /**
     * @var int
     *
     * @ORM\Column(name="km", type="integer")
     *
     * @Assert\Range(min=1, max=100000)
     */
    protected $km;

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
     * Get offer
     *
     * @return OfferAftersale
     */
    public function getOffer() : OfferAftersale
    {
        return $this->offer;
    }

    /**
     * Set offer
     *
     * @param OfferAftersale $offer
     *
     * @return OfferAftersaleTermsProperty
     */
    public function setOffer(OfferAftersale $offer)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Set km
     *
     * @param int $km
     *
     * @return OfferAftersaleTermsProperty
     */
    public function setKm(int $km)
    {
        $this->km = $km;

        return $this;
    }

    /**
     * Get km
     *
     * @return int
     */
    public function getKm()
    {
        return $this->km;
    }
}
