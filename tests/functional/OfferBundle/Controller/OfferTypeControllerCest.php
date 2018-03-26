<?php

namespace OfferBundle\Tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class OfferTypeControllerCest
{
    public function tryCGetTypeOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/offer/type/aftersale');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferType');
        $I->seeResponseContains('AFTERSALE');
        $I->dontSeeResponseContains('SECONDHANDCAR');
        $I->dontSeeResponseContains('NEWCAR');
    }

    public function tryCGetTypeEmpty(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/offer/type/test');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferType');
        $I->seeResponseContains('"data":[]');
    }
}