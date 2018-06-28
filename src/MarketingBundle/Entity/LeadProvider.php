<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;

/**
 * LeadProvider
 *
 * @ORM\Table(name="lead_provider")
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\LeadProviderRepository")
 */
class LeadProvider extends BaseEntity
{
}
