<?php

namespace OfferBundle\Entity\Traits;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Trait TimestampableOfferEntityTrait
 * @package OfferBundle\Entity\Traits
 */
trait TimestampableOfferEntityTrait
{
    /**
     * @var DateTime
     *
     * @Assert\GreaterThan(
     *     "today",
     *     message="StartDate must be higher than today"
     * )
     *
     * @ORM\Column(name="start_date", type="date")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $startDate;

    /**
     * @var DateTime
     *
     * @Assert\Expression(
     *     "value > this.getStartDate()",
     *     message="EndDate must be higher than StartDate"
     * )
     *
     * @ORM\Column(name="end_date", type="date")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $endDate;

    /**
     * Set startDate
     *
     * @param $startDate
     *
     * @return $this
     */
    public function setStartDate($startDate)
    {
        if ($startDate instanceof DateTime) {
            $this->startDate = $startDate;
        } else {
            $this->startDate = new DateTime($startDate);
        }

        return $this;
    }

    /**
     * Get startDate
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param string|DateTime$endDate
     *
     * @return $this
     */
    public function setEndDate($endDate)
    {
        if ($endDate instanceof DateTime) {
            $this->endDate = $endDate;
        } else {
            $this->endDate = new DateTime($endDate);
        }

        return $this;
    }

    /**
     * Get endDate
     *
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

}
