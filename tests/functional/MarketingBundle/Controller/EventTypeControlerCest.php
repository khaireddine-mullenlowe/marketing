<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class EventTypeControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryGetEventTypeOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/event-type/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"id":1');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryGetEventTypeKo(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/event-type/2');
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCGetEventTypeOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/event-type');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }
}
