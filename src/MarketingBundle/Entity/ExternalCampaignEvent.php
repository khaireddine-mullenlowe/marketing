<?php

namespace MarketingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
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
     * @var integer
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
    public function getProviderCampaignNumber()
    {
        return $this->providerCampaignNumber;
    }

    /**
     * @param string $providerCampaignNumber
     * @return $this
     */
    public function setProviderCampaignNumber($providerCampaignNumber)
    {
        $this->providerCampaignNumber = $providerCampaignNumber;

        return $this;
    }

    /**
     * @return ContactForm
     */
    public function getContactForm()
    {
        return $this->contactForm;
    }

    /**
     * @param ContactForm $contactForm
     * @return $this
     */
    public function setContactForm($contactForm)
    {
        $this->contactForm = $contactForm;

        return $this;
    }

    /**
     * Set modelId
     *
     * @param integer $modelId
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

}
