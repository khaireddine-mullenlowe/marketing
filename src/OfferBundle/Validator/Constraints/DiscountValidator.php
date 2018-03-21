<?php

namespace OfferBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class DiscountValidator
 */
class DiscountValidator extends ConstraintValidator
{
    public function validate($offerAftersale, Constraint $constraint)
    {
        $formType = $offerAftersale->getSubtype()->getFormType()->getType();

        switch ($formType) {
            case 'SIMPLE' :
                if (empty($offerAftersale->getDiscount1())) {
                    $constraint->message = 'Discount 1 must not be empty';
                } elseif (!empty($offerAftersale->getDiscount2()) || !empty($offerAftersale->getDiscount3())) {
                    $constraint->message = 'Discount 2 and 3 must be empty';
                }
                break;
            case 'DOUBLE' :
                if (empty($offerAftersale->getDiscount1()) || empty($offerAftersale->getDiscount2())) {
                    $constraint->message = 'Discount 1 and 2 must not be empty';
                } elseif (!empty($offerAftersale->getDiscount3())) {
                    $constraint->message = 'Discount 3 must be empty';
                }
                break;
            case 'TRIPLE' :
                if (empty($offerAftersale->getDiscount1()) || empty($offerAftersale->getDiscount2()) ||  empty($offerAftersale->getDiscount3())) {
                    $constraint->message = 'Discount 1 2 and 3 must not be empty';
                }
                break;
            default :
                if (!empty($offerAftersale->getDiscount1()) || !empty($offerAftersale->getDiscount2()) ||  !empty($offerAftersale->getDiscount3())) {
                    $constraint->message = 'Discount 1 2 and 3 must be empty';
                }
                break;
        }

        if (!empty($constraint->message)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}