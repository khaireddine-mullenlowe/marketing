<?php

namespace MarketingBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class MyaudiUserInvitationRepository
 * @package MarketingBundle\Repository
 */
class MyaudiUserInvitationRepository extends EntityRepository
{
    /**
     * @param array $filters
     * @return \Doctrine\ORM\Query
     */
    public function findByCustomFilters(array $filters)
    {
        $queryBuilder = $this->createQueryBuilder('a');

        foreach ($filters as $key => $filter) {
            $queryBuilder
                ->andWhere(sprintf('a.%s = :%s', $key, $key))
                ->setParameter($key, $filter);
        }

        $queryBuilder
            ->join('a.invitation', 'i')
            ->join('i.campaignEvent', 'ce')
            ->orderBy('ce.startDate', 'DESC');

        return $queryBuilder->getQuery();
    }
}
