<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SubscriptionControlerCest
 * @package MarketingBundle\tests\Controller
 */
class SubscriptionControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryGetSubscriptionOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/subscription/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"id":1');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryGetSubscriptionKo(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/subscription/2');
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCGetSubscriptionOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/subscription');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }
}
