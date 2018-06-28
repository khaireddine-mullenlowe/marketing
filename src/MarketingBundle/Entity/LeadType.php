<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;

/**
 * LeadType
 *
 * @ORM\Table(name="lead_type")
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\LeadTypeRepository")
 */
class LeadType extends BaseEntity
{
}
