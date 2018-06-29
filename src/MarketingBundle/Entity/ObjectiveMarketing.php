<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * ObjectiveMarketing
 *
 * @ORM\Table(name="objective_marketing")
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\ObjectiveMarketingRepository")
 */
class ObjectiveMarketing extends BaseEntity
{
    use LegacyTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;
}
