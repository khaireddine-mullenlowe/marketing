<?php

namespace MarketingBundle\Enum;

/**
 * Abstract Class for Enum.
 * @package OfferBundle\Enum
 */
class PaginateEnum
{
    const LIMIT = 10;
    const CURRENT_PAGE = 1;

    /**
     * @return array
     */
    public static function getData()
    {
        return [
            'limit' =>        self::LIMIT,
            'current_page' => self::CURRENT_PAGE,
        ];
    }
}
