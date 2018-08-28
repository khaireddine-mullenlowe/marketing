<?php
namespace MarketingBundle\Repository\Elastica;

use Elastica\Query\BoolQuery;
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

        $query = new BoolQuery();
        $queryString = new QueryString();
        foreach ($criterias as $field => $value) {
            $queryString
                ->setQuery(str_replace(" ", " AND ", trim($value)))
                ->setDefaultField($field);
            $query->addMust($queryString);
        }

        $result = $this->find($query);
        if (is_array($result) && 1 === count($result)) {
            return $result[0];
        }

        throw new \LogicException("Bad method call.");
    }
}
