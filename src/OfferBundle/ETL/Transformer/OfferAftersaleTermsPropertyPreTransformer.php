<?php

namespace OfferBundle\ETL\Transformer;

use Mullenlowe\EtlBundle\Row;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;

/**
 * Class MyaudiUserPreTransformer
 * @package OfferBundle\ETL\Transformer
 */
class OfferAftersaleTermsPropertyPreTransformer implements TransformerInterface
{
    /**
     * Transforms current data row by inner and/or custom mechanisms.
     *
     * @param Row $row
     *
     * @return Row
     */
    public function transform(Row $row): Row
    {
        $terms = $row->getColumn('terms');
        $termsValue = $terms->getValue();

        $pos = strpos($termsValue, 'd\'un entretien des');
        $posB = strpos($termsValue, 'km. V');

        $km = substr($termsValue, $pos + 19, ($posB - $pos - 20));

        $terms->setValue(str_replace(' ', '', $km));

        return $row;
    }
}
