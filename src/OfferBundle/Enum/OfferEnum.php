<?php

namespace OfferBundle\Enum;

use OfferBundle\Entity\OfferAftersaleMyaudiUser;
use OfferBundle\Entity\OfferSaleMyaudiUser;
use OfferBundle\Entity\OfferSecondhandCarTermsProperty;
use OfferBundle\Entity\OfferNewCarTermsProperty;
use OfferBundle\Form\OfferAftersaleTermsPropertyType;
use OfferBundle\Form\OfferAftersaleType;
use OfferBundle\Form\OfferNewCarTermsPropertyType;
use OfferBundle\Form\OfferSaleType;
use OfferBundle\Form\OfferSecondhandCarTermsPropertyType;
use OfferBundle\Entity\OfferAftersaleTermsProperty;
use OfferBundle\Entity\OfferSale;
use OfferBundle\Entity\OfferAftersale;

class OfferEnum
{
    const OFFERTYPE = [
        'aftersale'     => [
            'name'                  => 'Aftersale',
            'entity'                => OfferAftersale::class,
            'formType'              => OfferAftersaleType::class,
            'formTerms'             => OfferAftersaleTermsPropertyType::class,
            'repository'            => 'OfferBundle:OfferAftersale',
            'termsEntity'           => OfferAftersaleTermsProperty::class,
            'myaudiUser'            => OfferAftersaleMyaudiUser::class,
            'myaudiUserRepository'  => 'OfferBundle:OfferAftersaleMyaudiUser',
        ],
        'secondhandcar' => [
            'name'                  => 'SecondHandCar',
            'entity'                => OfferSale::class,
            'formType'              => OfferSaleType::class,
            'formTerms'             => OfferSecondhandCarTermsPropertyType::class,
            'repository'            => 'OfferBundle:OfferSale',
            'termsEntity'           => OfferSecondhandCarTermsProperty::class,
            'myaudiUser'            => OfferSaleMyaudiUser::class,
            'myaudiUserRepository'  => 'OfferBundle:OfferSaleMyaudiUser',
        ],
        'newcar'        => [
            'name'                  => 'NewCar',
            'entity'                => OfferSale::class,
            'formType'              => OfferSaleType::class,
            'formTerms'             => OfferNewCarTermsPropertyType::class,
            'repository'            => 'OfferBundle:OfferSale',
            'termsEntity'           => OfferNewCarTermsProperty::class,
            'myaudiUser'            => OfferSaleMyaudiUser::class,
            'myaudiUserRepository'  => 'OfferBundle:OfferSaleMyaudiUser',
        ],
    ];

    public static function getData()
    {
        return self::OFFERTYPE;
    }
}