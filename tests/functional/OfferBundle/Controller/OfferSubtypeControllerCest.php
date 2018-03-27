<?php

namespace OfferBundle\Tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class OfferSubtypeControllerCest
{
    public function tryCGetSubtypeOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/offer/subtype/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferSubtype');
        $I->seeResponseContains('terms');
        $I->seeResponseContains('formType');
    }

    public function tryCGetSubtypeEmpty(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/offer/subtype/9999');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContains('terms');
        $I->dontSeeResponseContains('formType');
    }
}