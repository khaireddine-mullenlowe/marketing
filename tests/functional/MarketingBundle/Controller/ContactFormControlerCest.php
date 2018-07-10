<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class ContactFormControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryGetContactFormOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/contact-form/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"id":1');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryGetContactFormeKo(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/contact-form/2');
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCGetContactFormOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/contact-form');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }
}
