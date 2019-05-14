<?php

namespace MarketingBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CampaignEventRepository
 * @package MarketingBundle\Repository
 */
class CampaignEventRepository extends EntityRepository
{
    /**
     * @param array $filters
     * @return \Doctrine\ORM\Query
     */
    public function findByCustomFilters(array $filters)
    {
        $queryBuilder = $this->createQueryBuilder('b');

        if (!empty($filters['eventType'])) {
            $queryBuilder
                ->where('b.startDate IS NOT NULL')
                ->andWhere('b.eventType = :eventType')
                ->setParameter('eventType', $filters['eventType']);
        }

        if (!empty($filters['startDate'])) {
            $queryBuilder
                ->orderBy('b.startDate', $filters['startDate']);
        }

        if (!empty($filters['endDate'])) {
            $queryBuilder
                ->orderBy('b.endDate', $filters['endDate']);
        }

        return $queryBuilder->getQuery();
    }
}
