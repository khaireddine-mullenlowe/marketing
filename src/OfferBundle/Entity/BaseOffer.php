<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OfferBundle\Entity\Traits\TimestampableOfferEntityTrait;
use Symfony\Component\Validator\Constraints as Assert;
use OfferBundle\Validator\Constraints as OfferAssert;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * BaseOffer
 *
 * @OfferAssert\OfferDates
 */
abstract class BaseOffer
{
    use TimestampableEntity;

    use TimestampableOfferEntityTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="partner_id", type="integer")
     *
     * @Groups({"rest"})
     */
    protected $partnerId;

    /**
     * @var string
     *
     * @ORM\Column(name="visual", type="string", length=255)
     *
     * @Groups({"rest"})
     */
    protected $visual;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="title", type="string", length=255)
     *
     * @Groups({"rest"})
     */
    protected $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Groups({"rest"})
     */
    protected $description;

    /**
     * @var int
     *
     * @Assert\Range(min = 0, max = 1)
     *
     * 0 = Inactivate, 1 = Activate
     *
     * @ORM\Column(name="status", type="integer", options={"default"=1})
     *
     * @Groups({"rest"})
     */
    protected $status;

    /**
     * @var bool
     *
     * If the partner has read and accepted the user terms for offer creation
     *
     * @ORM\Column(name="agreements", type="boolean")
     *
     * @Groups({"rest"})
     */
    protected $agreements;

    /**
     * BaseOffer constructor.
     */
    public function __construct()
    {
        $this->status = 1;
    }

    /**
     * Set partnerId
     *
     * @param integer $partnerId
     *
     * @return BaseOffer
     */
    public function setPartnerId($partnerId)
    {
        $this->partnerId = $partnerId;

        return $this;
    }

    /**
     * Get partnerId
     *
     * @return int
     */
    public function getPartnerId()
    {
        return $this->partnerId;
    }

    /**
     * Set visual
     *
     * @param string $visual
     *
     * @return BaseOffer
     */
    public function setVisual($visual)
    {
        $this->visual = $visual;

        return $this;
    }

    /**
     * Get visual
     *
     * @return string
     */
    public function getVisual()
    {
        return $this->visual;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return BaseOffer
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return BaseOffer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return BaseOffer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set agreements
     *
     * @param bool $agreements
     *
     * @return BaseOffer
     */
    public function setAgreements($agreements)
    {
        $this->agreements = $agreements;

        return $this;
    }

    /**
     * Get agreements
     *
     * @return bool
     */
    public function getAgreements()
    {
        return (int) $this->agreements;
    }
}
