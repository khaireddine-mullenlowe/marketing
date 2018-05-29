<?php

namespace OfferBundle\ETL\Transformer;

use Mullenlowe\EtlBundle\Row;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;

/**
 * Class MyaudiUserPreTransformer
 * @package OfferBundle\ETL\Transformer
 */
class OfferSecondhandCarTermsPropertyPreTransformer implements TransformerInterface
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

        $dynamicInputs =
        [
            '#modele#' => [
                'regex' => '/sur une Audi (A|Q|TT)([0-9]{1}[ ]{0,1}|[ ])([ABCS]{0,1}[a-zé ]{1,}|[ ])/',
                'start' => 8,
                'end' => 1,
            ],
            '#motorisation#' => [
                'regex' => '/(Midnight Series ){0,1}([0-9][.,][0-9]|[0-9]{2,3})[ TDIFSL]{0,}[a-zA-Z0-9 é.-]{0,} dans la/',
                'start' => 0,
                'end' => 9,
            ],
            '#email#' => [
                'regex' => '/mail suivante : .{1,}, soit/',
                'start' => 16,
                'end' => 6,
            ],
            '#adresse#' => [
                'regex' => '/adresse suivante : .{1,},/',
                'start' => 19,
                'end' => 1,
            ],
        ];

        foreach ($dynamicInputs as $key => $val) {
            preg_match($val['regex'], $termsValue, $res);

            $value = substr($res[0], $val['start'], -$val['end']);

            $currentRow = $row->getColumn(str_replace('#', '', $key));
            $currentRow->setValue($value);
        }

        $row->deleteColumn('terms');

        return $row;
    }
}
