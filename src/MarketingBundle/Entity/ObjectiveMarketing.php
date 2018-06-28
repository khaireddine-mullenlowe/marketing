<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;

/**
 * ObjectiveMarketing
 *
 * @ORM\Table(name="objective_marketing")
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\ObjectiveMarketingRepository")
 */
class ObjectiveMarketing extends BaseEntity
{
}
