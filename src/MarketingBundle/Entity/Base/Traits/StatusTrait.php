<?php

namespace MarketingBundle\Entity\Base\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait StatusTrait
 * @package MarketingBundle\Entity\Traits
 */
trait StatusTrait
{
    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    protected $status = 1;
    /**
     * Set status
     *
     * @param int $status
     *
     * @return $this
     */
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }
    /**
     * Get status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }
}