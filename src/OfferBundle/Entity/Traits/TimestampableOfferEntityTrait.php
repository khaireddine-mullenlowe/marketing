<?php

namespace OfferBundle\Entity\Traits;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

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
     */
    protected $endDate;

    /**
     * Set startDate
     *
     * @param string $startDate
     *
     * @return BaseOffer
     */
    public function setStartDate(string $startDate)
    {
        $this->startDate = new DateTime($startDate);

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
     * @param string $endDate
     *
     * @return BaseOffer
     */
    public function setEndDate(string $endDate)
    {
        $this->endDate = new DateTime($endDate);

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