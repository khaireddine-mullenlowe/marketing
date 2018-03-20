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
            case ('SIMPLE') :
                if (empty($offerAftersale->getDiscount1())) {
                    $constraint->message = 'test discount 1 empty';
                } elseif (!empty($offerAftersale->getDiscount2()) || !empty($offerAftersale->getDiscount3())) {
                    $constraint->message = 'test discount 2 or 3 not empty';
                }
                break;
            case ('DOUBLE') :
                if (empty($offerAftersale->getDiscount1()) || empty($offerAftersale->getDiscount2())) {
                    $constraint->message = 'test discount 1 or 2 empty';
                } elseif (!empty($offerAftersale->getDiscount3())) {
                    $constraint->message = 'test discount 3 not empty';
                }
                break;
            case ('TRIPLE') :
                if (empty($offerAftersale->getDiscount1()) || empty($offerAftersale->getDiscount2()) ||  empty($offerAftersale->getDiscount3())) {
                    $constraint->message = 'test discount 1 2 or 3 empty';
                }
                break;
            default :
                if (!empty($offerAftersale->getDiscount1()) || !empty($offerAftersale->getDiscount2()) ||  !empty($offerAftersale->getDiscount3())) {
                    $constraint->message = 'test discount 1 2 or 3 not empty';
                }
                break;
        }

        if (!empty($constraint->message)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}