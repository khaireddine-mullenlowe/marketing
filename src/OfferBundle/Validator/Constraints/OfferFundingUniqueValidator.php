<?php

namespace OfferBundle\Validator\Constraints;


use Doctrine\Common\Persistence\ObjectManager;
use OfferBundle\Entity\OfferFunding;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class OfferFundingUniqueValidator extends ConstraintValidator
{
    /** @var ObjectManager */
    protected $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
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

        $offer = $this->em->getRepository('OfferBundle:OfferFunding')
            ->findOneBy(['label' => $value->getLabel()]);
        if (null === $offer) {
            return;
        }

        $actualStartDate = $offer->getStartDate();
        $actualEndDate = $offer->getEndDate();
        $newStartDate = $value->getStartDate();
        $newEndDate = $value->getEndDate();

        if ($this->between($newStartDate, $actualStartDate, $actualEndDate) ||
            $this->between($newEndDate, $actualStartDate, $actualEndDate) ||
            $this->between($actualEndDate, $newStartDate, $newEndDate) ||
            $this->between($actualEndDate, $newStartDate, $newEndDate)) {

            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value->getLabel())
                ->addViolation();
        }
    }

    /**
     * Check if needle date is between tow dates.
     * @param \DateTime $needleDate
     * @param \DateTime $startDate
     * @param \DateTime $endDate
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