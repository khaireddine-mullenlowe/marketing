<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * MarketingObjective
 *
 * @ORM\Table(name="marketing_objective", indexes={@ORM\Index(name="MarketingObjective_LegacyId_idx", columns={"legacy_id"})})
 * @ORM\Entity()
 */
class MarketingObjective extends BaseEntity
{
    use LegacyTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;
}
