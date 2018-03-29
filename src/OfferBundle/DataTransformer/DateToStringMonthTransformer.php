<?php

namespace OfferBundle\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class DateToStringMonthTransformer
 * @package OfferBundle\DataTransformer
 */
class DateToStringMonthTransformer implements DataTransformerInterface
{
    /**
     * @param string $value
     * @return string
     */
    public function transform($value)
    {
        return ($value);
    }

    /**
     * @param string $value
     * @return string
     */
    public function reverseTransform($value)
    {
        return (strftime('%d %B %Y', strtotime($value)));
    }
}
