<?php

namespace OfferBundle\Service;

use InvalidArgumentException;
use OfferBundle\Entity\OfferSubtype;

/**
 * Class OfferTerms
 * @package OfferBundle\Service
 */
class OfferTerms
{

    /**
     * @param mixed        $form
     * @param mixed        $data
     * @param OfferSubtype $subtype
     * @return array
     * @internal param array $data
     */
    public function generateNewTerms($form, $data, OfferSubtype $subtype)
    {
        $finalTerms = $subtype->getTerms();

        $dataForTerms = $data['terms'];
        $dataForTerms['startDate'] = $data['offer']['startDate'];
        $dataForTerms['endDate']   = $data['offer']['endDate'];

        $form->submit($dataForTerms);

        $dataToInsert = $form->getData();

        foreach ($dataToInsert as $key => $value) {
            $finalTerms = str_replace('#'.$key.'#', $value, $finalTerms);
        }

        $regex = '/\#[a-zA-Z2]{1,20}\#/';

        preg_match($regex, $finalTerms, $res);

        if (!empty($res)) {
            throw new InvalidArgumentException('Terms are not complete');
        }

        return $finalTerms;
    }
}
