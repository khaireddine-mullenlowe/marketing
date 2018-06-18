<?php

namespace OfferBundle\ETL\Constraint;

use Mullenlowe\EtlBundle\Constraint\ConstraintInterface;
use OfferBundle\Enum\OfferFundingTypeEnum;
use Mullenlowe\EtlBundle\Mapping\Column;

/**
 * Class OfferFundingTypeConstraint
 * @package OfferBundle\ETL\Constraint
 */
class OfferFundingTypeConstraint implements ConstraintInterface
{
    const LEGACY_TYPE_NATIONAL = 5988;
    const LEGACY_TYPE_LOCAL = 5989;

    /**
     * {@inheritDoc}
     */
    public static function apply(Column $column)
    {
        $legacyValue = $column->getValue();

        if (self::LEGACY_TYPE_NATIONAL == $legacyValue) {
            $value = OfferFundingTypeEnum::TYPE_NATIONAL;
        } elseif (self::LEGACY_TYPE_LOCAL == $legacyValue) {
            $value = OfferFundingTypeEnum::TYPE_LOCAL;
        } else {
            throw new \UnexpectedValueException(sprintf('Unable to map offer type value %d', $legacyValue));
        }

        $column->setValue($value);
    }
}
