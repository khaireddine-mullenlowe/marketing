<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OfferSecondhandCarTermsProperty
 *
 * @ORM\Table(name="offer_secondhand_car_terms_property")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferSecondhandCarTermsPropertyRepository")
 */
class OfferSecondhandCarTermsProperty
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
     * @var OfferSale
     *
     * @ORM\OneToOne(
     *     targetEntity="OfferSale",
     *     inversedBy="termsPropertySecondhandCar"
     * )
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    protected $offer;

    /**
     * @var string
     *
     * @ORM\Column(name="model_name", type="string", length=255)
     */
    protected $modelName;

    /**
     * @var string
     *
     * @ORM\Column(name="engine", type="string", length=255)
     */
    protected $engine;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\Email()
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    protected $address;

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
     * Set offer
     *
     * @param OfferSale $offer
     *
     * @return OfferSecondhandCarTermsProperty
     */
    public function setOffer(OfferSale $offer)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return OfferSale
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set modelName
     *
     * @param string $modelName
     *
     * @return OfferSecondhandCarTermsProperty
     */
    public function setModelName(string $modelName)
    {
        $this->modelName = $modelName;

        return $this;
    }

    /**
     * Get modelName
     *
     * @return string
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * Set engine
     *
     * @param string $engine
     *
     * @return OfferSecondhandCarTermsProperty
     */
    public function setEngine(string $engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Get engine
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return OfferSecondhandCarTermsProperty
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return OfferSecondhandCarTermsProperty
     */
    public function setAddress(string $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
}
