<?php

namespace OfferBundle\Validator\Constraints;

use OfferBundle\Entity\OfferFunding;
use OfferBundle\Repository\OfferFundingRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class OfferFundingUniqueValidator
 * @package OfferBundle\Validator\Constraints
 */
class OfferFundingUniqueValidator extends ConstraintValidator
{
    /** @var OfferFundingRepository */
    protected $entityRepository;

    /**
     * OfferFundingUniqueValidator constructor.
     * @param OfferFundingRepository $repository
     */
    public function __construct(OfferFundingRepository $repository)
    {
        $this->entityRepository = $repository;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof OfferFundingUnique) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\OfferFundingUnique');
        }

        if (!$value instanceof OfferFunding) {
            throw new UnexpectedTypeException($value, 'OfferFunding');
        }

        $offer = $this->entityRepository->findOneBy(['name' => $value->getName()]);
        if (null === $offer || (null !== $value->getId() && $value->getId() === $offer->getId())) {
            return;
        }

        $actualStartDate = $offer->getStartDate();
        $actualEndDate = $offer->getEndDate();
        $newStartDate = $value->getStartDate();
        $newEndDate = $value->getEndDate();

        if ($this->between($newStartDate, $actualStartDate, $actualEndDate) ||
            $this->between($newEndDate, $actualStartDate, $actualEndDate) ||
            $this->between($actualEndDate, $newStartDate, $newEndDate) ||
            $this->between($actualEndDate, $newStartDate, $newEndDate)
        ) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value->getName())
                ->addViolation();
        }
    }

    /**
     * Check if needle date is between tow dates.
     * @param \DateTime $needleDate
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param bool $strict
     * @return bool True if $needleDate is between $startDate and $endDate ().
     */
    private function between(\DateTime $needleDate, \DateTime $startDate, \DateTime $endDate, $strict = false) : bool
    {
        if ($strict) {
            return $startDate->diff($needleDate)->format('%R%a') > 0 &&
                $needleDate->diff($endDate)->format('%R%a') > 0;
        }

        return $startDate->diff($needleDate)->format('%R%a') >= 0 &&
            $needleDate->diff($endDate)->format('%R%a') >= 0;
    }
}
