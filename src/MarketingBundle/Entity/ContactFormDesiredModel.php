<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactFormDesiredModel
 *
 * @ORM\Table(name="contact_form_desired_model")
 * @ORM\Entity()
 */
class ContactFormDesiredModel
{
    /**
     * @var ContactForm
     *
     * @ORM\ManyToOne(
     *     targetEntity="ContactForm",
     *     inversedBy="desiredModels"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\Id()
     */
    protected $contactForm;

    /**
     * @var int
     *
     * @ORM\Column(name="desired_model_id", type="integer", length=255)
     * @ORM\Id()
     */
    protected $desiredModelId;

    /**
     * Set contactForm
     *
     * @param ContactForm $contactForm
     *
     * @return ContactFormDesiredModel
     */
    public function setContactForm(ContactForm $contactForm)
    {
        $this->contactForm = $contactForm;

        return $this;
    }

    /**
     * Get contactForm
     *
     * @return ContactForm
     */
    public function getContactForm()
    {
        return $this->contactForm;
    }

    /**
     * Set desiredModelId
     *
     * @param int $desiredModelId
     *
     * @return ContactFormDesiredModel
     */
    public function setDesiredModelId($desiredModelId)
    {
        $this->desiredModelId = $desiredModelId;

        return $this;
    }

    /**
     * Get desiredModelId
     *
     * @return int
     */
    public function getDesiredModelId()
    {
        return $this->desiredModelId;
    }
}
