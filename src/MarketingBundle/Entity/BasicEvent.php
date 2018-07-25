<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BasicEvent
 *
 * @ORM\Table(name="basic_event")
 * @ORM\Entity()
 */
class BasicEvent
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
    protected $campaignEvent;

    /**
     * @var bool
     *
     * @ORM\Column(name="ticketing", type="boolean")
     */
    protected $ticketing;

    /**
     * @var bool
     *
     * @ORM\Column(name="allow_multiple_sessions", type="boolean")
     */
    protected $allowMultipleSessions;

    /**
     * @var bool
     *
     * @ORM\Column(name="paid_invitation", type="boolean")
     */
    protected $paidInvitation;

    /**
     * @var float
     *
     * @ORM\Column(name="invitation_cost", type="float")
     */
    protected $invitationCost;

    /**
     * @var float
     *
     * @ORM\Column(name="invitation_cost_with_accompagnant", type="float")
     */
    protected $invitationCostWithAccompagnant;

    /**
     * @var bool
     *
     * @ORM\Column(name="admin_increments_quota", type="boolean")
     */
    protected $adminIncrementsQuota;

    /**
     * @var bool
     *
     * @ORM\Column(name="confirm_prospect_on_creation", type="boolean")
     */
    protected $confirmProspectOnCreation;

    /**
     * @param CampaignEvent $campaignEvent
     * @return BasicEvent
     */
    public function setCampaignEvent($campaignEvent)
    {
        $this->campaignEvent = $campaignEvent;

        return $this;
    }

    /**
     * Get campaignEvent
     *
     * @return CampaignEvent
     */
    public function getCampaignEvent()
    {
        return $this->campaignEvent;
    }

    /**
     * Set ticketing
     *
     * @param boolean $ticketing
     *
     * @return BasicEvent
     */
    public function setTicketing($ticketing)
    {
        $this->ticketing = $ticketing;

        return $this;
    }

    /**
     * Get ticketing
     *
     * @return bool
     */
    public function getTicketing()
    {
        return $this->ticketing;
    }

    /**
     * Set allowMultipleSessions
     *
     * @param boolean $allowMultipleSessions
     *
     * @return BasicEvent
     */
    public function setAllowMultipleSessions($allowMultipleSessions)
    {
        $this->allowMultipleSessions = $allowMultipleSessions;

        return $this;
    }

    /**
     * Get allowMultipleSessions
     *
     * @return bool
     */
    public function getAllowMultipleSessions()
    {
        return $this->allowMultipleSessions;
    }

    /**
     * Set paidInvitation
     *
     * @param boolean $paidInvitation
     *
     * @return BasicEvent
     */
    public function setPaidInvitation($paidInvitation)
    {
        $this->paidInvitation = $paidInvitation;

        return $this;
    }

    /**
     * Get paidInvitation
     *
     * @return bool
     */
    public function getPaidInvitation()
    {
        return $this->paidInvitation;
    }

    /**
     * Set invitationCost
     *
     * @param float $invitationCost
     *
     * @return BasicEvent
     */
    public function setInvitationCost($invitationCost)
    {
        $this->invitationCost = $invitationCost;

        return $this;
    }

    /**
     * Get invitationCost
     *
     * @return float
     */
    public function getInvitationCost()
    {
        return $this->invitationCost;
    }

    /**
     * Set invitationCostWithAccompagnant
     *
     * @param float $invitationCostWithAccompagnant
     *
     * @return BasicEvent
     */
    public function setInvitationCostWithAccompagnant($invitationCostWithAccompagnant)
    {
        $this->invitationCostWithAccompagnant = $invitationCostWithAccompagnant;

        return $this;
    }

    /**
     * Get invitationCostWithAccompagnant
     *
     * @return float
     */
    public function getInvitationCostWithAccompagnant()
    {
        return $this->invitationCostWithAccompagnant;
    }

    /**
     * Set adminIncrementsQuota
     *
     * @param boolean $adminIncrementsQuota
     *
     * @return BasicEvent
     */
    public function setAdminIncrementsQuota($adminIncrementsQuota)
    {
        $this->adminIncrementsQuota = $adminIncrementsQuota;

        return $this;
    }

    /**
     * Get adminIncrementsQuota
     *
     * @return bool
     */
    public function getAdminIncrementsQuota()
    {
        return $this->adminIncrementsQuota;
    }

    /**
     * Set confirmProspectOnCreation
     *
     * @param boolean $confirmProspectOnCreation
     *
     * @return BasicEvent
     */
    public function setConfirmProspectOnCreation($confirmProspectOnCreation)
    {
        $this->confirmProspectOnCreation = $confirmProspectOnCreation;

        return $this;
    }

    /**
     * Get confirmProspectOnCreation
     *
     * @return bool
     */
    public function getConfirmProspectOnCreation()
    {
        return $this->confirmProspectOnCreation;
    }
}
