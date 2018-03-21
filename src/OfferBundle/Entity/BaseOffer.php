<?php

namespace OfferBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use OfferBundle\Validator\Constraints as OfferAssert;

/**
 * BaseOffer
 *
 * @OfferAssert\OfferDates
 */
abstract class BaseOffer
{
    /**
     * @var int
     *
     * @ORM\Column(name="partner_id", type="integer")
     */
    protected $partner;

    /**
     * @var DateTime
     *
     * @Assert\GreaterThan(
     *     "today",
     *     message="StartDate must be higher than today"
     * )
     *
     * @ORM\Column(name="start_date", type="date")
     */
    protected $startDate;

    /**
     * @var DateTime
     *
     * @Assert\Expression(
     *     "value > this.getStartDate()",
     *     message="EndDate must be higher than StartDate"
     * )
     *
     * @ORM\Column(name="end_date", type="date")
     */
    protected $endDate;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @var DateTime
     *
     * @Assert\Expression("value >= this.getCreatedAt()")
     *
     * @ORM\Column(name="updated_at", type="datetime", options={"default"="CURRENT_TIMESTAMP"})
     */
    protected $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="visual", type="string", length=255)
     */
    protected $visual;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="subtitle", type="string", length=255)
     */
    protected $subtitle;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="terms", type="text")
     */
    protected $terms;

    /**
     * @var int
     *
     * @Assert\Range(min = 0, max = 1)
     *
     * @ORM\Column(name="status", type="integer", options={"default"=1})
     */
    protected $status;

    /**
     * @var bool
     *
     * @ORM\Column(name="agreements", type="boolean")
     */
    protected $agreements;

    public function __construct()
    {
        $this->createdAt = new DateTime('now');
        $this->updatedAt = new DateTime('now');
        $this->status = 1;
    }

    /**
     * Set partner
     *
     * @param integer $partner
     *
     * @return BaseOffer
     */
    public function setPartner($partner)
    {
        $this->partner = $partner;

        return $this;
    }

    /**
     * Get partner
     *
     * @return int
     */
    public function getPartner()
    {
        return $this->partner;
    }

    /**
     * Set startDate
     *
     * @param string $startDate
     *
     * @return BaseOffer
     */
    public function setStartDate(string $startDate)
    {
        $this->startDate = new DateTime($startDate);

        return $this;
    }

    /**
     * Get startDate
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param string $endDate
     *
     * @return BaseOffer
     */
    public function setEndDate(string $endDate)
    {
        $this->endDate = new DateTime($endDate);

        return $this;
    }

    /**
     * Get endDate
     *
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return BaseOffer
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param DateTime $updatedAt
     *
     * @return BaseOffer
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
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
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return BaseOffer
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
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
     * Set terms
     *
     * @param string $terms
     *
     * @return BaseOffer
     */
    public function setTerms($terms)
    {
        $this->terms = $terms;

        return $this;
    }

    /**
     * Get terms
     *
     * @return string
     */
    public function getTerms()
    {
        return $this->terms;
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
     * @param boolean $agreements
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
        return $this->agreements;
    }
}