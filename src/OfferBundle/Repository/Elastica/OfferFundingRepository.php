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
    /**
     * @param $name
     * @return array
     */
    public function findByName($name)
    {
        $match = new Match();
        $match->setField('name', $name);

        $query = new BoolQuery();
        $query->addMust($match);

        return $this->find($query);
    }
}