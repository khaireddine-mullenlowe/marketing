<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * EntryPoint
 *
 * @ORM\Table(name="entry_point", indexes={@ORM\Index(name="EntryPoint_LegacyId_idx", columns={"legacy_id"})})
 * @ORM\Entity()
 */
class EntryPoint extends BaseEntity
{
    use LegacyTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;
}
