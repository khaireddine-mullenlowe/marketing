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
    public $message = 'La date de début et la date de fin doivent avoir en 3 et 92 jours de différence';

    public function getTargets()
    {
        return array(self::PROPERTY_CONSTRAINT, self::CLASS_CONSTRAINT);
    }

}