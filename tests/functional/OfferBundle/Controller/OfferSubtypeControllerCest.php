<?php

namespace OfferBundle\Tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class OfferSubtypeControllerCest
{
    public function tryGetSubtypeOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/offer/subtype/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferSubtype');
        $I->seeResponseContains('terms');
        $I->seeResponseContains('formType');
    }

    public function tryGetSubtypeEmpty(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/offer/subtype/9999');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContains('terms');
        $I->dontSeeResponseContains('formType');
    }

    public function tryCGetSubtypeOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/offer/subtype/type/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferSubtype');
        $I->seeResponseContains('terms');
        $I->seeResponseContains('formType');
    }

    public function tryCGetSubtypeEmpty(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/offer/subtype/type/9999');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->dontSeeResponseContains('terms');
        $I->dontSeeResponseContains('formType');
    }
}