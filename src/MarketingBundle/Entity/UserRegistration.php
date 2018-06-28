<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;

/**
 * UserRegistration
 *
 * @ORM\Table(name="user_registration")
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\UserRegistrationRepository")
 */
class UserRegistration extends BaseEntity
{
}
