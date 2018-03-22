<?php

namespace OfferBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Discount
 * @package OfferBundle\Validator\Constraints
 * @Annotation
 */
class Discount extends Constraint
{
    public $message = '';

    public function getTargets()
    {
        return array(self::PROPERTY_CONSTRAINT, self::CLASS_CONSTRAINT);
    }
}