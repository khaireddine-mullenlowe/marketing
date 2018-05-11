<?php

namespace OfferBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OfferAftersaleRepository
 */
class OfferAftersaleRepository extends EntityRepository
{
    /**
     * @param string|null $partnerIds
     * @return mixed
     */
    public function findOffersSinceAYear(string $partnerIds = null)
    {
        $date = date('Y-m-d', strtotime("-1 year", strtotime(date('Y-m-d'))));

        $qb = $this->createQueryBuilder('offer');
        $qb
            ->leftJoin('offer.termsProperty', 'terms')
            ->where('offer.endDate > :date')
            ->setParameter(':date', $date)
            ->orderBy('offer.createdAt');

        if (!empty($partnerIds)) {
            $partnerIds = explode(',', $partnerIds);
            $qb->andWhere('offer.partnerId IN (:partners)')
                ->setParameter(':partners', $partnerIds);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $myaudiUserId
     * @return array
     */
    public function findByMyaudiUser(int $myaudiUserId)
    {
        $date = date('y-m-d');

        return $this->createQueryBuilder('offer')
            ->innerJoin('offer.myaudiUsers', 'myaudiUsers')
            ->leftJoin('offer.termsProperty', 'terms')
            ->where('offer.agreements = 1')
            ->andWhere('offer.status = 1')
            ->andWhere('myaudiUsers.myaudiUserId = :myaudiUserId')
            ->andWhere(':date BETWEEN offer.startDate AND offer.endDate')
            ->setParameter('myaudiUserId', $myaudiUserId)
            ->setParameter('date', $date)
            ->orderBy('offer.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
