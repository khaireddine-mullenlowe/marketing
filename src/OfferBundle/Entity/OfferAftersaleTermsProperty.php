<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferTermsProperty
 *
 * @ORM\Table(name="offer_terms_property")
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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     */
    private $value;

    /**
     * @var OfferAftersale
     *
     * @ORM\ManyToOne(
     *     targetEntity="OfferAftersale",
     *     inversedBy="termsProperties"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $offer;

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
     * Set name
     *
     * @param string $name
     *
     * @return OfferAftersaleTermsProperty
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return OfferAftersaleTermsProperty
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
}
