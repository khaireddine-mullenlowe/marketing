<?php

namespace OfferBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class OfferFundingUnique
 * @package OfferBundle\Validator\Constraints
 * @Annotation
 */
class OfferFundingUnique extends Constraint
{
    public $message = 'A funding "{{ value }}" already exists in this period.';

    /**
     * @return mixed
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}