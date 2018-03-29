<?php

namespace OfferBundle\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

/**
 * Class ThousandSeparationTransformer
 * @package OfferBundle\DataTransformer
 */
class ThousandSeparationTransformer implements DataTransformerInterface
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
        return number_format($value, 0, '', ' ');
    }
}
