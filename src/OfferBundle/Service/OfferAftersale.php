<?php

namespace OfferBundle\Service;

use Doctrine\ORM\EntityManager;
use OfferBundle\Entity\OfferAftersale as Aftersale;

class OfferAftersale
{
    protected $subTypeRepository;

    protected $em;
    protected $formType;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function checkSubtype($data)
    {
        $subtype = ($this->em->getRepository("OfferBundle:OfferSubtype"))->find($data['subtype']);

        if (empty($subtype)) {
            throw new \InvalidArgumentException('Le sous type de l\'offre est invalide');
        }

        return ['subtype' => $subtype, 'type' => $subtype->getType()->getCategory()];
    }
}