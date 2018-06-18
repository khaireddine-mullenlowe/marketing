<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\Timestampable;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;
use OfferBundle\Entity\Traits\TimestampableOfferEntityTrait;
use OfferBundle\Validator\Constraints\OfferFundingUnique;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use OfferBundle\Enum\OfferFundingTypeEnum;
use Gedmo\Mapping\Annotation as Gedmo;

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
    use Timestampable;
    use LegacyTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"rest"})
     */
    private $id;

    /**
     *
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Choice({OfferFundingTypeEnum::TYPE_NATIONAL, OfferFundingTypeEnum::TYPE_LOCAL}, strict=true)
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     * @Groups({"rest"})
     */
    private $type;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="model_id", type="integer")
     * @Groups({"rest"})
     */
    private $modelId;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="range_id", type="integer")
     * @Groups({"rest"})
     */
    private $rangeId;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"rest"})
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="price", type="string", length=255)
     * @Groups({"rest"})
     */
    private $price;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="details", type="text")
     * @Groups({"rest"})
     */
    private $details;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="legalNotice", type="text")
     * @Groups({"rest"})
     */
    private $legalNotice;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="visual", type="text")
     * @Groups({"rest"})
     */
    private $visual;

    /**
     * @var int
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(name="with_contribution", type="smallint")
     * @Groups({"rest"})
     */
    private $withContribution = 0;

    /**
     * @var int
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(name="guaranteed", type="smallint")
     * @Groups({"rest"})
     */
    private $guaranteed = 0;

    /**
     * @var int
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(name="maintained", type="smallint")
     * @Groups({"rest"})
     */
    private $maintained = 0;

    /**
     * @var \DateTime
     *
     * @Assert\GreaterThan(
     *     "today",
     *     message="StartDate must be higher than today"
     * )
     *
     * @ORM\Column(name="start_date", type="date")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $startDate;

    /**
     * @var \DateTime
     *
     * @Assert\Expression(
     *     "value > this.getStartDate()",
     *     message="EndDate must be higher than StartDate"
     * )
     *
     * @ORM\Column(name="end_date", type="date")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $endDate;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     * @Groups({"rest"})
     */
     protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     * @Groups({"rest"})
     */
    protected $updatedAt;

    /**
     * @var int
     *
     * @Assert\Range(min = 0, max = 1)
     *
     * @ORM\Column(name="status", type="smallint")
     * @Groups({"rest"})
     */
    private $status = 1;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"rest"})
     */
    protected $legacyId;


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
     * @param int $withContribution
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
     * @return int
     */
    public function isWithContribution()
    {
        return $this->withContribution;
    }

    /**
     * Set guaranteed
     *
     * @param int $guaranteed
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
     * @return int
     */
    public function isGuaranteed()
    {
        return $this->guaranteed;
    }

    /**
     * Set maintained
     *
     * @param int $maintained
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
     * @return int
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
     * Set status
     *
     * @param int $status
     *
     * @return $this
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
     * Set Name
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __clone()
    {
        $this->startDate = clone $this->startDate;
        $this->endDate = clone $this->endDate;
    }
}

