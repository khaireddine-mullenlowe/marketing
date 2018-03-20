<?php

namespace OfferBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class OfferDatesValidator
 */
class OfferDatesValidator extends ConstraintValidator
{
    public function validate($offer, Constraint $constraint)
    {
        $startDate = $offer->getStartDate();
        $endDate = $offer->getEndDate();

        $diff = intval(date_diff($startDate, $endDate)->format('%a'));

        if ($diff < 3 || $diff > 92) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}