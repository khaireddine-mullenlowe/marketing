<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MarketingBundle\Entity\Base\BaseEntity;
use Mullenlowe\CommonBundle\Entity\Traits\LegacyTrait;

/**
 * ContactFormType
 *
 * @ORM\Table(
 *     name="contact_form_type",
 *     indexes={@ORM\Index(name="ContactFormType_LegacyId_idx", columns={"legacy_id"})}
 * )
 * @ORM\Entity()
 */
class ContactFormType extends BaseEntity
{
    use LegacyTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $legacyId;
}
