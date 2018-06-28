<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartnerEvent
 *
 * @ORM\Table(name="partner_event")
 * @ORM\Entity()
 */
class PartnerEvent
{
    /**
     * @var CampaignEvent
     *
     * @ORM\OneToOne(
     *     targetEntity="CampaignEvent"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\Id()
     */
    protected $event;

    /**
     * @var bool
     *
     * @ORM\Column(name="audi_sport_event", type="boolean")
     */
    protected $audiSportEvent;

    /**
     * @var int
     *
     * @ORM\Column(name="generic_quota", type="integer")
     */
    protected $genericQuota;

    /**
     * @var bool
     *
     * @ORM\Column(name="with_accompagnants", type="boolean")
     */
    protected $withAccompagnants;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="edit_quota_end_date", type="datetime")
     */
    protected $editQuotaEndDate;

    /**
     * Set event
     *
     * @param CampaignEvent $event
     *
     * @return PartnerEvent
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return CampaignEvent
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set audiSportEvent
     *
     * @param boolean $audiSportEvent
     *
     * @return PartnerEvent
     */
    public function setAudiSportEvent($audiSportEvent)
    {
        $this->audiSportEvent = $audiSportEvent;

        return $this;
    }

    /**
     * Get audiSportEvent
     *
     * @return boolean
     */
    public function isAudiSportEvent()
    {
        return $this->audiSportEvent;
    }

    /**
     * Set genericQuota
     *
     * @param integer $genericQuota
     *
     * @return PartnerEvent
     */
    public function setGenericQuota($genericQuota)
    {
        $this->genericQuota = $genericQuota;

        return $this;
    }

    /**
     * Get genericQuota
     *
     * @return int
     */
    public function getGenericQuota()
    {
        return $this->genericQuota;
    }

    /**
     * Set withAccompagnants
     *
     * @param boolean $withAccompagnants
     *
     * @return PartnerEvent
     */
    public function setWithAccompagnants($withAccompagnants)
    {
        $this->withAccompagnants = $withAccompagnants;

        return $this;
    }

    /**
     * Get withAccompagnants
     *
     * @return boolean
     */
    public function isWithAccompagnants()
    {
        return $this->withAccompagnants;
    }

    /**
     * Set editQuotaEndDate
     *
     * @param \DateTime $editQuotaEndDate
     *
     * @return PartnerEvent
     */
    public function setEditQuotaEndDate($editQuotaEndDate)
    {
        $this->editQuotaEndDate = $editQuotaEndDate;

        return $this;
    }

    /**
     * Get editQuotaEndDate
     *
     * @return \DateTime
     */
    public function getEditQuotaEndDate()
    {
        return $this->editQuotaEndDate;
    }
}
