<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * CallCenter
 *
 * @ORM\Table(name="call_center")
 * @ORM\Entity()
 */
class CallCenter extends BaseEntity
{
    use LegacyTrait;
}
