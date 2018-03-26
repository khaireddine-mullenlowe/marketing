<?php

namespace OfferBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OfferFormTypeName
 *
 * @ORM\Table(name="offer_form_type")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferFormTypeRepository")
 */
class OfferFormType
{
    const TYPE = [
        'BASIC',
        'SIMPLE',
        'DOUBLE',
        'TRIPLE',
    ];

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var string
     *
     * The type is used to identify how many discount must be filled
     *
     * @ORM\Column(name="type", type="string")
     */
    protected $type;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="OfferSubtype",
     *     mappedBy="formType",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $subtypes;

    /**
     * OfferFormType constructor.
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
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return OfferFormType
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return OfferFormType
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return OfferFormType
     */
    public function setType(string $type)
    {
        if (!in_array($type, self::TYPE)) {
            throw new \InvalidArgumentException('Invalid category for OfferType');
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
