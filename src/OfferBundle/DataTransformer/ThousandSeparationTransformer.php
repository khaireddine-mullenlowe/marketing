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
        $strArray = explode('.', $value);

        if (!empty($strArray[1])) {
            return number_format($value, 2, ',', ' ');
        } else {
            return number_format($value, 0, ',', ' ');
        }
    }
}
