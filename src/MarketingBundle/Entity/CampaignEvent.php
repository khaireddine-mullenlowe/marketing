<?php

namespace MarketingBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * Campaign
 *
 * @ORM\Table(name="campaign_event", indexes={@ORM\Index(name="CampaignEvent_LegacyId_idx", columns={"legacy_id"})})
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\CampaignEventRepository")
 */
class CampaignEvent extends BaseEntity
{
    use LegacyTrait;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="waiting_list", type="boolean")
     */
    protected $waitingList = 0;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="start_date", type="datetime", nullable=true)
     */
    protected $startDate;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    protected $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="description_event", type="text", nullable=true)
     */
    protected $descriptionEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="description_target", type="text", nullable=true)
     */
    protected $descriptionTarget;

    /**
     * @var EventType
     *
     * @ORM\ManyToOne(targetEntity="EventType")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $eventType;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="ContactForm",
     *     mappedBy="event"
     * )
     */
    protected $contactForms;


    /**
     * Set description
     *
     * @param string $description
     *
     * @return CampaignEvent
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
     * Set waitingList
     *
     * @param integer $waitingList
     *
     * @return CampaignEvent
     */
    public function setWaitingList($waitingList)
    {
        $this->waitingList = $waitingList;

        return $this;
    }

    /**
     * Get waitingList
     *
     * @return boolean
     */
    public function isWaitingList()
    {
        return $this->waitingList;
    }

    /**
     * @param DateTime $startDate
     * @return CampaignEvent
     */
    public function setStartDate(DateTime $startDate = null)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param DateTime $endDate
     *
     * @return CampaignEvent
     */
    public function setEndDate(DateTime $endDate = null)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set descriptionEvent
     *
     * @param string $descriptionEvent
     *
     * @return CampaignEvent
     */
    public function setDescriptionEvent($descriptionEvent)
    {
        $this->descriptionEvent = $descriptionEvent;

        return $this;
    }

    /**
     * Get descriptionEvent
     *
     * @return string
     */
    public function getDescriptionEvent()
    {
        return $this->descriptionEvent;
    }

    /**
     * Set descriptionTarget
     *
     * @param string $descriptionTarget
     *
     * @return CampaignEvent
     */
    public function setDescriptionTarget($descriptionTarget)
    {
        $this->descriptionTarget = $descriptionTarget;

        return $this;
    }

    /**
     * Get descriptionTarget
     *
     * @return string
     */
    public function getDescriptionTarget()
    {
        return $this->descriptionTarget;
    }

    /**
     * @param EventType $eventType
     * @return $this
     */
    public function setEventType(EventType $eventType)
    {
        $this->eventType = $eventType;

        return $this;
    }

    /**
     * @return EventType
     */
    public function getEventType()
    {
        return $this->eventType;
    }
}
