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
     * @param array $orderBy
     * @return \Doctrine\ORM\Query
     */
    public function findByCustomFilters(array $filters, array $orderBy)
    {
        $queryBuilder = $this->createQueryBuilder('b');

        if (!empty($filters['eventType'])) {
            $queryBuilder
                ->where('b.startDate IS NOT NULL')
                ->andWhere('b.eventType = :eventType')
                ->setParameter('eventType', $filters['eventType']);
        }

        if (!empty($filters['name'])) {
            $queryBuilder
                ->andWhere('b.name = :name')
                ->setParameter('name', $filters['name']);
        }

        if (!empty($orderBy['startDate'])) {
            $queryBuilder
                ->orderBy('b.startDate', $orderBy['startDate']);
        }

        if (!empty($orderBy['endDate'])) {
            $queryBuilder
                ->orderBy('b.endDate', $orderBy['endDate']);
        }

        return $queryBuilder->getQuery();
    }
}
