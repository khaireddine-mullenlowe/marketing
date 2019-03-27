<?php

namespace MarketingBundle\Repository\Elastica;

use Elastica\Query\BoolQuery;
use Elastica\Query\Match;
use Elastica\Query\QueryString;
use FOS\ElasticaBundle\Repository;

/**
 * Class ContactFormRepository
 * @package MarketingBundle\Repository\Elastica
 */
class ContactFormRepository extends Repository
{
    /**
     * Find one Contact form by criteria.
     * @param array $criterias
     * @return mixed
     */
    public function findOneBy(array $criterias)
    {
        if (empty($criterias)) {
            throw new \InvalidArgumentException("Data not valid.");
        }

        $boolQuery = new BoolQuery();
        foreach ($criterias as $field => $value) {
            if ('name' !== $field) {
                $query = new QueryString();
                $query
                    ->setQuery(str_replace(" ", " AND ", trim($value)))
                    ->setDefaultField($field);
            } else {
                $query = new Match();
                $query
                    ->setFieldQuery($field, str_replace('-', ' ', $value))
                    ->setFieldOperator($field, Match::OPERATOR_AND);
            }

            $boolQuery->addMust($query);
        }

        $result = $this->find($boolQuery);
        if (is_array($result) && 1 <= count($result)) {
            return $result[0];
        }

        return null;
    }
}
