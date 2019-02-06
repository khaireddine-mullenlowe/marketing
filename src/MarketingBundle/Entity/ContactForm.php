<?php

namespace MarketingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * ContactForm
 *
 * @ORM\Table(name="contact_form", indexes={@ORM\Index(name="ContactForm_LegacyId_idx", columns={"legacy_id"})})
 * @ORM\Entity()
 */
class ContactForm
{
    use LegacyTrait;
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var CampaignEvent
     *
     * @ORM\ManyToOne(
     *     targetEntity="CampaignEvent",
     *     inversedBy="contactForms"
     * )
     */
    protected $campaignEvent;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="ExternalCampaignEvent",
     *     mappedBy="contactForm"
     * )
     */
    protected $externalCampaignEvents;

    /**
     * @var Subscription
     *
     * @ORM\ManyToOne(
     *     targetEntity="Subscription"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $subscription;

    /**
     * @var EntryPoint
     *
     * @ORM\ManyToOne(
     *     targetEntity="EntryPoint"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $entryPoint;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="create_prospect_account", type="boolean")
     */
    protected $createProspectAccount = 1;

    /**
     * @var string
     *
     * @ORM\Column(name="tracking_code_init", type="text", nullable=true)
     */
    protected $trackingCodeInit;

    /**
     * @var string
     *
     * @ORM\Column(name="tracking_code_validation", type="text", nullable=true)
     */
    protected $trackingCodeValidation;

    /**
     * @var bool
     *
     * @ORM\Column(name="send_email_to_crm", type="boolean")
     */
    protected $sendEmailToCrm = 1;

    /**
     * @var bool
     *
     * @ORM\Column(name="send_email_to_cdv", type="boolean")
     */
    protected $sendEmailToCdv = 0;

    /**
     * @var LeadProvider
     *
     * @ORM\ManyToOne(
     *     targetEntity="LeadProvider"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $leadProvider;

    /**
     * @var ContactFormType
     *
     * @ORM\ManyToOne(
     *     targetEntity="ContactFormType"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $contactFormType;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * ContactForm constructor.
     */
    public function __construct()
    {
        $this->externalCampaignEvents = new ArrayCollection();
    }

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
     * Set event
     *
     * @param string $campaignEvent
     *
     * @return ContactForm
     */
    public function setCampaignEvent($campaignEvent)
    {
        $this->campaignEvent = $campaignEvent;

        return $this;
    }

    /**
     * Get campaignEvent
     *
     * @return string
     */
    public function getCampaignEvent()
    {
        return $this->campaignEvent;
    }

    /**
     * Set subscription
     *
     * @param string $subscription
     *
     * @return ContactForm
     */
    public function setSubscription($subscription)
    {
        $this->subscription = $subscription;

        return $this;
    }

    /**
     * Get subscription
     *
     * @return string
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Set entryPoint
     *
     * @param string $entryPoint
     *
     * @return ContactForm
     */
    public function setEntryPoint($entryPoint)
    {
        $this->entryPoint = $entryPoint;

        return $this;
    }

    /**
     * Get entryPoint
     *
     * @return string
     */
    public function getEntryPoint()
    {
        return $this->entryPoint;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ContactForm
     */
    public function setName($name): ContactForm
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ContactForm
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
     * Set createProspectAccount
     *
     * @param boolean $createProspectAccount
     *
     * @return ContactForm
     */
    public function setCreateProspectAccount($createProspectAccount)
    {
        $this->createProspectAccount = $createProspectAccount;

        return $this;
    }

    /**
     * Get createProspectAccount
     *
     * @return bool
     */
    public function getCreateProspectAccount()
    {
        return $this->createProspectAccount;
    }

    /**
     * @return string
     */
    public function getTrackingCodeInit()
    {
        return $this->trackingCodeInit;
    }

    /**
     * @param string $trackingCodeInit
     *
     * @return ContactForm
     */
    public function setTrackingCodeInit($trackingCodeInit): ContactForm
    {
        $this->trackingCodeInit = $trackingCodeInit;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrackingCodeValidation()
    {
        return $this->trackingCodeValidation;
    }

    /**
     * @param string $trackingCodeValidation
     *
     * @return ContactForm
     */
    public function setTrackingCodeValidation($trackingCodeValidation): ContactForm
    {
        $this->trackingCodeValidation = $trackingCodeValidation;

        return $this;
    }

    /**
     * Set sendEmailToCrm
     *
     * @param boolean $sendEmailToCrm
     *
     * @return ContactForm
     */
    public function setSendEmailToCrm($sendEmailToCrm)
    {
        $this->sendEmailToCrm = $sendEmailToCrm;

        return $this;
    }

    /**
     * Get sendEmailToCrm
     *
     * @return bool
     */
    public function getSendEmailToCrm()
    {
        return $this->sendEmailToCrm;
    }

    /**
     * Set sendEmailToCdv
     *
     * @param boolean $sendEmailToCdv
     *
     * @return ContactForm
     */
    public function setSendEmailToCdv($sendEmailToCdv)
    {
        $this->sendEmailToCdv = $sendEmailToCdv;

        return $this;
    }

    /**
     * Get sendEmailToCdv
     *
     * @return bool
     */
    public function getSendEmailToCdv()
    {
        return $this->sendEmailToCdv;
    }

    /**
     * Set leadProvider
     *
     * @param LeadProvider $leadProvider
     *
     * @return ContactForm
     */
    public function setLeadProvider(LeadProvider $leadProvider)
    {
        $this->leadProvider = $leadProvider;

        return $this;
    }

    /**
     * Get leadProvider
     *
     * @return LeadProvider
     */
    public function getLeadProvider()
    {
        return $this->leadProvider;
    }

    /**
     * Set contactFormType
     *
     * @param string $contactFormType
     *
     * @return ContactForm
     */
    public function setContactFormType($contactFormType)
    {
        $this->contactFormType = $contactFormType;

        return $this;
    }

    /**
     * Get contactFormType
     *
     * @return string
     */
    public function getContactFormType()
    {
        return $this->contactFormType;
    }

    /**
     * @return ArrayCollection
     */
    public function getExternalCampaignEvents()
    {
        return $this->externalCampaignEvents;
    }

    /**
     * @param ArrayCollection $externalCampaignEvents
     * @return $this
     */
    public function setExternalCampaignEvents($externalCampaignEvents)
    {
        $this->externalCampaignEvents = $externalCampaignEvents;

        return $this;
    }

    /**
     * @param CampaignEvent $externalCampaignEvent
     */
    public function addExternalCampaignEvent(ExternalCampaignEvent $externalCampaignEvent)
    {
        if (! $this->externalCampaignEvents->contains($externalCampaignEvent)) {
            $this->externalCampaignEvents->add($externalCampaignEvent);
        }
    }

}
