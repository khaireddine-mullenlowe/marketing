<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * Interest
 *
 * @ORM\Table(name="interest", indexes={@ORM\Index(name="Interest_LegacyId_idx", columns={"legacy_id"})})
 * @ORM\Entity()
 */
class Interest extends BaseEntity
{
    use LegacyTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;
}
