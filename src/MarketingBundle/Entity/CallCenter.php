<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;

/**
 * CallCenter
 *
 * @ORM\Table(name="call_center")
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\CallCenterRepository")
 */
class CallCenter extends BaseEntity
{
}
