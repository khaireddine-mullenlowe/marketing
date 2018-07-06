<?php

namespace MarketingBundle\Entity\Base\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Trait NameTrait
 * @package MarketingBundle\Entity\Traits
 */
trait NameTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    protected $name;
    /**
     * Set name
     *
     * @param string $name
     *
     * @return $this
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
    public function getName()
    {
        return $this->name;
    }
}