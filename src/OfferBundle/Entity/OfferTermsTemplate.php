<?php

namespace OfferBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OfferTerms
 *
 * @ORM\Table(name="offer_terms_template")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferTermsTemplateRepository")
 */
class OfferTermsTemplate
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
     *
     * @ORM\Column(name="template", type="text")
     */
    protected $template;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="OfferSubtype",
     *     mappedBy="termsTemplate",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $subtypes;

    /**
     * OfferTermsTemplate constructor.
     */
    public function __construct()
    {
        $this->subtypes = new ArrayCollection();
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
     * Set template
     *
     * @param string $template
     *
     * @return OfferTermsTemplate
     */
    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Get template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }
}

