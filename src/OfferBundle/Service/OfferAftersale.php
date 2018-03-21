<?php

namespace OfferBundle\Service;

use Doctrine\ORM\EntityManager;

class OfferAftersale
{
    protected $em;

    /**
     * OfferAftersale constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $data
     * @return array
     */
    public function checkSubtype($data)
    {
        if (!empty($data['subtype'])) {
            $subtype = ($this->em->getRepository("OfferBundle:OfferSubtype"))->find($data['subtype']);
        }

        if (empty($subtype)) {
            throw new \InvalidArgumentException('Invalid OfferSubtype');
        }

        return ['subtype' => $subtype, 'type' => $subtype->getType()->getCategory()];
    }
}