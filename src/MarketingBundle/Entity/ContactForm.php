<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactForm
 *
 * @ORM\Table(name="contact_form")
 * @ORM\Entity()
 */
class ContactForm
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
     * @var CampaignEvent
     *
     * @ORM\ManyToOne(
     *     targetEntity="CampaignEvent",
     *     inversedBy="contactForms"
     * )
     */
    private $event;

    /**
     * @var Subscription
     *
     * @ORM\ManyToOne(
     *     targetEntity="Subscription"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $subscription;

    /**
     * @var EntryPoint
     *
     * @ORM\ManyToOne(
     *     targetEntity="EntryPoint"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $entryPoint;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="create_prospect_account", type="boolean")
     */
    private $createProspectAccount;

    /**
     * @var bool
     *
     * @ORM\Column(name="send_email_to_crm", type="boolean")
     */
    private $sendEmailToCrm;

    /**
     * @var bool
     *
     * @ORM\Column(name="send_email_to_cdv", type="boolean")
     */
    private $sendEmailToCdv;

    /**
     * @var string
     *
     * @ORM\ManyToOne(
     *     targetEntity="LeadProvider"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $leadProvider;

    /**
     * @var ContactFormType
     *
     * @ORM\ManyToOne(
     *     targetEntity="ContactFormType"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $contactFormType;


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
     * @param string $event
     *
     * @return ContactForm
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
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
     * @param string $leadProvider
     *
     * @return ContactForm
     */
    public function setLeadProvider($leadProvider)
    {
        $this->leadProvider = $leadProvider;

        return $this;
    }

    /**
     * Get leadProvider
     *
     * @return string
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
}

