<?php

namespace OfferBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Dates
 * @package OfferBundle\Validator\Constraints
 * @Annotation
 */
class OfferDates extends Constraint
{
    public $message = 'StartDate and EndDate must have a diff between 3 days and 92 days';

    /**
     * @return array
     */
    public function getTargets()
    {
        return array(self::PROPERTY_CONSTRAINT, self::CLASS_CONSTRAINT);
    }

}