<?php

namespace OfferBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OfferFundingRepository
 *
 */
class OfferFundingRepository extends EntityRepository
{
    /**
     * @param array $params
     * @param bool  $mostRecent
     * @param bool  $isActif
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByCustomFilters(array $params, bool $mostRecent = false, bool $isActif = true)
    {

        $queryBuilder = $this->createQueryBuilder('funding');
        if (isset($params['model'])) {
            $queryBuilder
                ->andWhere('funding.modelId = :modelId')
                ->setParameter('modelId', $params['model']);
        } elseif (isset($params['range'])) {
            $queryBuilder
                ->andWhere('funding.rangeId = :rangeId')
                ->setParameter('rangeId', $params['range']);
        }

        if ($mostRecent) {
            $queryBuilder->orderBy('funding.createAt', 'desc');
        }

        if ($isActif) {
            $queryBuilder
                ->andWhere('funding.status = 1')
                ->andWhere('funding.startDate <= :today')
                ->andWhere('funding.endDate >= :today')
                ->setParameter('today', new \DateTime());
        }

        return $queryBuilder->orderBy('funding.createdAt', 'desc');
    }
}
