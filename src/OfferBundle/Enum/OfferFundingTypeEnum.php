<?php

namespace OfferBundle\Enum;

/**
 * Class OfferFundingTypeEnum
 * @package OfferBundle\Enum
 */
class OfferFundingTypeEnum extends BaseEnum
{
    const TYPE_NATIONAL = 'national';
    const TYPE_LOCAL = 'local';
    /**
     * @return array
     */
    public static function getData()
    {
        return [
            self::TYPE_NATIONAL => 'Nationale',
            self::TYPE_LOCAL    => 'Locale',
        ];
    }
}
