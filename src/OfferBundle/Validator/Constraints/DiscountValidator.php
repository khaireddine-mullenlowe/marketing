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
                if (empty($offerAftersale->getDiscountSimple())) {
                    $constraint->message = 'Discount simple must not be empty';
                } elseif (!empty($offerAftersale->getDiscountDouble()) || !empty($offerAftersale->getDiscountTriple())) {
                    $constraint->message = 'Discount double and triple must be empty';
                }
                break;
            case 'DOUBLE' :
                if (empty($offerAftersale->getDiscountSimple()) || empty($offerAftersale->getDiscountDouble())) {
                    $constraint->message = 'Discount simple and double must not be empty';
                } elseif (!empty($offerAftersale->getDiscountTriple())) {
                    $constraint->message = 'Discount triple must be empty';
                }
                break;
            case 'TRIPLE' :
                if (empty($offerAftersale->getDiscountSimple()) || empty($offerAftersale->getDiscountDouble()) || empty($offerAftersale->getDiscountTriple())) {
                    $constraint->message = 'Discount simple, double and triple must not be empty';
                }
                break;
            default :
                if (!empty($offerAftersale->getDiscountSimple()) || !empty($offerAftersale->getDiscountDouble()) || !empty($offerAftersale->getDiscountTriple())) {
                    $constraint->message = 'Discount simple, double and triple must be empty';
                }
                break;
        }

        if (!empty($constraint->message)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}