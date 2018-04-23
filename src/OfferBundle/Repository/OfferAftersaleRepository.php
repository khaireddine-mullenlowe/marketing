<?php

namespace OfferBundle\Repository;

/**
 * OfferAftersaleRepository
 */
class OfferAftersaleRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     *
     * @param array|null $partnersIds
     * @return mixed
     */
    public function findOffersSinceAYear(array $partnersIds = null)
    {
        $date = date('Y-m-d', strtotime("-1 year", strtotime(date('Y-m-d'))));

        $qb = $this->_em->createQueryBuilder();
        $qb
            ->select('offer')
            ->from($this->_entityName, 'offer')
            ->leftJoin('offer.termsProperty', 'terms')
            ->where('offer.endDate > :date')
            ->setParameter(':date', $date)
            ->orderBy('offer.createdAt');

        if (!empty($partnersIds)) {
            $qb->andWhere('offer.partnerId IN (:partners)')
                ->setParameter(':partners', $partnersIds);
        }

        return $qb->getQuery()->getResult();
    }
}
