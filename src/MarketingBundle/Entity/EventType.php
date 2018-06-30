<?php

namespace MarketingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * EventType
 *
 * @ORM\Table(name="event_type", indexes={@ORM\Index(name="EventType_LegacyId_idx", columns={"legacy_id"})})
 * @ORM\Entity()
 */
class EventType extends BaseEntity
{
    use LegacyTrait;

    /**
     * @var EventType|null
     *
     * @ORM\ManyToOne(targetEntity="MarketingBundle\Entity\EventType", inversedBy="subEventTypes")
     * @ORM\JoinColumn(name="parent_event_type_id", referencedColumnName="id", nullable=true)
     */
    protected $parentEventType;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MarketingBundle\Entity\EventType", mappedBy="parentEventType")
     */
    protected $subEventTypes;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;

    /**
     * EventType constructor.
     */
    public function __construct()
    {
        $this->subEventTypes = new ArrayCollection();
    }

    /**
     * @return EventType|null
     */
    public function getParentEventType()
    {
        return $this->parentEventType;
    }

    /**
     * @param EventType|null $parentEventType
     *
     * @return EventType
     */
    public function setParentEventType($parentEventType): EventType
    {
        $this->parentEventType = $parentEventType;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSubEventTypes()
    {
        return $this->subEventTypes;
    }

    /**
     * @param ArrayCollection $subEventTypes
     *
     * @return EventType
     */
    public function setSubEventTypes($subEventTypes): EventType
    {
        $this->subEventTypes = $subEventTypes;
        foreach ($subEventTypes as $subEventType) {
            $subEventType->setParentEventType($this);
        }

        return $this;
    }

    /**
     * @param EventType $subEventType
     *
     * @return EventType
     */
    public function addSubProfile(EventType $subEventType): EventType
    {
        if (!$this->subEventTypes->contains($subEventType)) {
            $subEventType->setParentEventType($this);
            $this->subEventTypes->add($subEventType);
        }

        return $this;
    }

    /**
     * @param EventType $subEventType
     *
     * @return EventType
     */
    public function removeSubProfile(EventType $subEventType): EventType
    {
        $subEventType->setParentEventType(null);
        $this->subEventTypes->removeElement($subEventType);

        return $this;
    }
}
