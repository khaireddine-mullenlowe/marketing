<?php

namespace OfferBundle\ETL\Transformer;

use Mullenlowe\EtlBundle\Row;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;

/**
 * Class MyaudiUserPreTransformer
 * @package OfferBundle\ETL\Transformer
 */
class OfferNewCarTermsPropertyPreTransformer implements TransformerInterface
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
            '#nombre_de_mois#' => [
                'regex' => '/durée sur <b>[0-9]{1,2}<\/b> <b>mois<\/b>./',
                'start' => 14,
                'end' => 17,
            ],
            '#premier_loyer#' => [
                'regex' => '/1er loyer de <b>[0-9 ,.]{1,8}<\/b> € et/',
                'start' => 16,
                'end' => 11,
                'type' => 'int',
            ],
            '#date_du_tarif#' => [
                'regex' => '/Tarifs au [0-9]{2}\/[0-9]{2}\/[0-9]{4}./',
                'start' => 10,
                'end' => 1,
                'type' => 'date',
            ],
            '#modele#' => [
                'regex' => '/\*Exemple pour Audi (A|Q|TT)([0-9]{1}[ ]{0,1}|[ ])([ABCS]{0,1}[a-zé ]{1,}|[ ])/',
                'start' => 14,
                'end' => 1,
            ],
            '#motorisation#' => [
                'regex' => '/(Midnight Series ){0,1}([0-9][.,][0-9]|[0-9]{2,3})[ TDIFSL]{0,}[a-zA-Z0-9 îé.-]{0,} avec options/',
                'start' => 0,
                'end' => 13,
            ],
            '#options#' => [
                'regex' => '/avec options [a-zA-Z0-9éèàâ,\/\-\'" ()+.]{1,} en location/',
                'start' => 13,
                'end' => 12,
            ],
            '#gamme#' => [
                'regex' => '/Gamme [A|Q|T]{1,2}[0-9]{0,1} /',
                'start' => 6,
                'end' => 1,
            ],
            '#consommation1#' => [
                'regex' => '/\(l\/100km\) : <b>([0-9]{1,2}[.,]{1}[0-9]{1,2}|[1-9]{1,3})<\/b> –/',
                'start' => 15,
                'end' => 8,
                'type' => 'float',
            ],
            '#consommation2#' => [
                'regex' => '/– <b>([0-9]{1,2}[.,]{1}[0-9]{1,2}|[1-9]{1,3})<\/b>\. Rejets/',
                'start' => 7,
                'end' => 12,
                'type' => 'float',
            ],
            '#co2_emission1#' => [
                'regex' => '/\(g\/km\) : <b>[0-9]{1,4}[.,]{0,1}[0-9]{1,4}<\/b> -/',
                'start' => 12,
                'end' => 6,
                'type' => 'float',
            ],
            '#co2_emission2#' => [
                'regex' => '/- <b>[0-9]{1,4}[.,]{0,1}[0-9]{1,4}<\/b>\./',
                'start' => 5,
                'end' => 5,
                'type' => 'float',
            ],
            '#km_maximum#' => [
                'regex' => '/et pour [0-9 ]{1,10} km max/',
                'start' => 8,
                'end' => 7,
                'type' => 'int',
            ],
            '#partenaire#' => [
                'regex' => '/Distributeurs [a-zA-Z0-9 \'-]{1,} présentant/',
                'start' => 14,
                'end' => 12,
            ],
        ];

        foreach ($dynamicInputs as $key => $val) {
            preg_match($val['regex'], $termsValue, $res);

            if (empty($res)) {
                var_dump($val['regex']);
            }

            $value = substr($res[0], $val['start'], -$val['end']);

            if (!empty($val['type'])) {
                if ($val['type'] === 'float') {
                    $value = str_replace(',', '.', $value);
                } elseif ($val['type'] === 'int') {
                    $value = str_replace(' ', '', $value);
                    $value = intval(str_replace(',', '.', $value));
                } elseif ($val['type'] === 'date') {
                    $dateArray = explode('/', $value);
                    $value = $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0];
                }
            }

            $currentRow = $row->getColumn(str_replace('#', '', $key));
            $currentRow->setValue($value);
        }

        $row->deleteColumn('terms');

        return $row;
    }
}
