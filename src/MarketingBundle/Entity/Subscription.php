<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * Subscription
 *
 * @ORM\Table(name="subscription", indexes={@ORM\Index(name="Subscription_LegacyId_idx", columns={"legacy_id"})})
 * @ORM\Entity()
 */
class Subscription extends BaseEntity
{
    use LegacyTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;
}
