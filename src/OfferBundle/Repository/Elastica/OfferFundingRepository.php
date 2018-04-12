<?php

namespace OfferBundle\Repository\Elastica;

use Elastica\Query\BoolQuery;
use Elastica\Query\Match;
use FOS\ElasticaBundle\Repository;

/**
 * Class OfferFundingRepository
 * @package OfferBundle\Repository\Elastica
 */
class OfferFundingRepository extends Repository
{
    public function findByLabel($label)
    {
        $match = new Match();
        $match->setField('label', $label);

        $query = new BoolQuery();
        $query->addMust($match);
        return $this->find($query);
    }
}