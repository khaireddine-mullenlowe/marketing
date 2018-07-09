<?php

namespace MarketingBundle\Entity\Base;

use MarketingBundle\Entity\Base\Traits\NameTrait;
use MarketingBundle\Entity\Base\Traits\StatusTrait;
use Mullenlowe\CommonBundle\Entity\Base\BaseEntity as CommonBaseEntity;

/**
 * Class BaseEntity
 * @package MarketingBundle\Entity\Base
 */
abstract class BaseEntity extends CommonBaseEntity
{
    use StatusTrait;
    use NameTrait;
}
