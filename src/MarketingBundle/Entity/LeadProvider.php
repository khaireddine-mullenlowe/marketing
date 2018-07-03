<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * LeadProvider
 *
 * @ORM\Table(name="lead_provider", indexes={@ORM\Index(name="LeadProvider_LegacyId_idx", columns={"legacy_id"})})
 * @ORM\Entity()
 */
class LeadProvider extends BaseEntity
{
    use LegacyTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;
}
