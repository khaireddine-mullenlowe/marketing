<?php

namespace OfferBundle\Validator\Constraints;

use OfferBundle\Entity\OfferAftersale;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class DiscountValidator
 */
class DiscountValidator extends ConstraintValidator
{
    /**
     * @param OfferAftersale $offerAftersale
     * @param Constraint     $constraint
     */
    public function validate($offerAftersale, Constraint $constraint)
    {
        $formType = $offerAftersale->getSubtype()->getFormType()->getType();

        $discountSimple = $offerAftersale->getDiscountSimple();
        $discountDouble = $offerAftersale->getDiscountDouble();
        $discountTriple = $offerAftersale->getDiscountTriple();

        switch ($formType) {
            case 'SIMPLE':
                if (empty($discountSimple)) {
                    $constraint->message = 'Discount simple must not be empty';
                } elseif (!empty($discountDouble) || !empty($discountTriple)
                ) {
                    $constraint->message = 'Discount double and triple must be empty';
                }
                break;
            case 'DOUBLE':
                if (empty($discountSimple) || empty($discountDouble)
                ) {
                    $constraint->message = 'Discount simple and double must not be empty';
                } elseif (!empty($discountTriple)) {
                    $constraint->message = 'Discount triple must be empty';
                }
                break;
            case 'TRIPLE':
                if (empty($discountSimple) ||  empty($discountDouble) || empty($discountTriple)
                ) {
                    $constraint->message = 'Discount simple, double and triple must not be empty';
                }
                break;
            default:
                if (!empty($discountSimple) || !empty($discountDouble) || !empty($discountTriple)
                ) {
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
