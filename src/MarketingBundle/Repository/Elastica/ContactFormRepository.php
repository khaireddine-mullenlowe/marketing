<?php
namespace MarketingBundle\Repository\Elastica;

use Elastica\Query\BoolQuery;
use Elastica\Query\QueryString;
use FOS\ElasticaBundle\Repository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ContactFormRepository
 * @package MarketingBundle\Repository\Elastica
 */
class ContactFormRepository extends Repository
{
    /**
     * Find one Contact form by criteria.
     * @param array $criteria
     * @return mixed
     */
    public function findOneBy(array $criteria)
    {
        if (empty($criteria)) {
            throw new \InvalidArgumentException("Data not valid.");
        }

        $query = new BoolQuery();
        $queryString = new QueryString();

        foreach ($criteria as $field => $value) {
            $queryString
                ->setQuery(str_replace(" ", " AND ", trim($value)))
                ->setDefaultField($field);
            $query->addMust($queryString);
        }

        $result = $this->find($query);

        if (is_array($result) && 1 === count($result)) {
            return $result[0];
        }

        throw new NotFoundHttpException('No contact form found');
    }
}
