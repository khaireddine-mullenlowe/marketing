<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;

/**
 * Interest
 *
 * @ORM\Table(name="interest")
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\InterestRepository")
 */
class Interest extends BaseEntity
{
}
