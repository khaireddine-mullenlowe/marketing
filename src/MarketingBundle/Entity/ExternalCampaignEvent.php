<?php

namespace MarketingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity;

/**
 * ExternalCampaignEvent
 * Table de stockages des campagne externe (marquetis, odity...)
 *
 * @ORM\Table(name="external_campaign_event")
 * @ORM\Entity()
 */
class ExternalCampaignEvent extends BaseEntity
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotNull
     *
     *
     * @ORM\Column(name="provider", type="text", nullable=false)
     */
    protected $provider;

    /**
     * @var string
     * @Assert\NotNull
     *
     * @ORM\Column(name="provider_campaign_number", type="text", nullable=false)
     */
    private $providerCampaignNumber;

    /**
     * @var string
     * @Assert\NotNull
     *
     * @ORM\Column(name="model_id", type="integer", nullable=false)
     */
    private $modelId;

    /**
     * @var ContactForm
     *
     * @ORM\ManyToOne(
     *     targetEntity="ContactForm",
     *     inversedBy="externalMarketingEvents"
     * )
     */
    protected $contactForm;

    /**
     * Set provider
     *
     * @param string $provider
     *
     * @return ExternalCampaignEvent
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return string
     */
    public function getProviderCampaignNumber(): string
    {
        return $this->providerCampaignNumber;
    }

    /**
     * @param string $providerCampaignNumber
     */
    public function setProviderCampaignNumber(string $providerCampaignNumber)
    {
        $this->providerCampaignNumber = $providerCampaignNumber;
    }

    /**
     * @return ContactForm
     */
    public function getContactForm(): ContactForm
    {
        return $this->contactForm;
    }

    /**
     * @param ContactForm $contactForm
     */
    public function setContactForm(ContactForm $contactForm)
    {
        $this->contactForm = $contactForm;
    }

    /**
     * Set modelId
     *
     * @param string $modelId
     *
     * @return ExternalCampaignEvent
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * Get modelId
     *
     * @return string
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * Add contactForm
     *
     * @param \MarketingBundle\Entity\ContactForm $contactForm
     *
     * @return ExternalCampaignEvent
     */
    public function addContactForm(\MarketingBundle\Entity\ContactForm $contactForm)
    {
        $this->contactForms[] = $contactForm;

        return $this;
    }

    /**
     * Remove contactForm
     *
     * @param \MarketingBundle\Entity\ContactForm $contactForm
     */
    public function removeContactForm(\MarketingBundle\Entity\ContactForm $contactForm)
    {
        $this->contactForms->removeElement($contactForm);
    }

    /**
     * Get contactForms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContactForms()
    {
        return $this->contactForms;
    }
}
