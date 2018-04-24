<?php

namespace OfferBundle\Repository;

/**
 * OfferAftersaleRepository
 */
class OfferAftersaleRepository extends \Doctrine\ORM\EntityRepository
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
}
