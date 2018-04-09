<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OfferBundle\Entity\Traits\TimestampableOfferEntityTrait;
use OfferBundle\Validator\Constraints\OfferFundingUnique;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OfferFunding
 *
 * @ORM\Table(name="offer_funding")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferFundingRepository")
 * @OfferFundingUnique
 */
class OfferFunding
{
    use TimestampableOfferEntityTrait;

    Const TYPES = [
        'NATIONAL',
        'LOCAL',
    ];

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
     * @Assert\NotBlank()
     *
     * @SWG\Property
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property
     * @ORM\Column(name="model_id", type="integer")
     */
    private $modelId;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property
     * @ORM\Column(name="range_id", type="integer")
     */
    private $rangeId;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @var bool
     *
     * @Assert\NotNull()
     *
     * @SWG\Property
     * @ORM\Column(name="with_contribution", type="boolean")
     */
    private $withContribution = false;

    /**
     * @var bool
     *
     * @Assert\NotNull()
     *
     * @SWG\Property
     * @ORM\Column(name="guaranteed", type="boolean")
     */
    private $guaranteed = false;

    /**
     * @var bool
     *
     * @Assert\NotNull()
     *
     * @SWG\Property
     * @ORM\Column(name="maintained", type="boolean")
     */
    private $maintained = false;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property
     * @ORM\Column(name="details", type="text")
     */
    private $details;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property
     * @ORM\Column(name="legalNotice", type="text")
     */
    private $legalNotice;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property
     * @ORM\Column(name="visual", type="text")
     */
    private $visual;

    /**
     * @var bool
     *
     * @Assert\NotNull()
     *
     * @SWG\Property
     * @ORM\Column(name="active", type="boolean")
     */
    private $active = false;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @SWG\Property
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;


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
     * Set type
     *
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        if (!in_array($type, self::TYPES)) {
            throw new \InvalidArgumentException('Invalid type value.');
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set modelId
     *
     * @param integer $modelId
     *
     * @return $this
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * Get modelId
     *
     * @return int
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * Set rangeId
     *
     * @param string $rangeId
     *
     * @return $this
     */
    public function setRangeId($rangeId)
    {
        $this->rangeId = $rangeId;

        return $this;
    }

    /**
     * Get rangeId
     *
     * @return string
     */
    public function getRangeId()
    {
        return $this->rangeId;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set withContribution
     *
     * @param boolean $withContribution
     *
     * @return $this
     */
    public function setWithContribution($withContribution)
    {
        $this->withContribution = $withContribution;

        return $this;
    }

    /**
     * Get withContribution
     *
     * @return bool
     */
    public function isWithContribution()
    {
        return $this->withContribution;
    }

    /**
     * Set guaranteed
     *
     * @param boolean $guaranteed
     *
     * @return $this
     */
    public function setGuaranteed($guaranteed)
    {
        $this->guaranteed = $guaranteed;

        return $this;
    }

    /**
     * Get guaranteed
     *
     * @return bool
     */
    public function isGuaranteed()
    {
        return $this->guaranteed;
    }

    /**
     * Set maintained
     *
     * @param boolean $maintained
     *
     * @return $this
     */
    public function setMaintained($maintained)
    {
        $this->maintained = $maintained;

        return $this;
    }

    /**
     * Get maintained
     *
     * @return bool
     */
    public function isMaintained()
    {
        return $this->maintained;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return $this
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
     * Set legalNotice
     *
     * @param string $legalNotice
     *
     * @return $this
     */
    public function setLegalNotice($legalNotice)
    {
        $this->legalNotice = $legalNotice;

        return $this;
    }

    /**
     * Get legalNotice
     *
     * @return string
     */
    public function getLegalNotice()
    {
        return $this->legalNotice;
    }

    /**
     * Set visual
     *
     * @param string $visual
     *
     * @return $this
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
     * Set active
     *
     * @param boolean $active
     *
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    public function __clone()
    {
        $this->startDate = clone $this->startDate;
        $this->endDate = clone $this->endDate;
    }
}

