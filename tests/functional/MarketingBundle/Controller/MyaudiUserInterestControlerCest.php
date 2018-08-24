<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class MyaudiUserInterestControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryCGetMyaudiUserInterestOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/interest-user/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }

    public function tryPostMyaudiUserInterestOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":2, "interest": 1}';

        $I->sendPOST('/interest-user/', $data);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
    }

    public function tryDeleteMyaudiUserInterestObjectiveOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendDELETE('/interest-user/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'MyaudiUserInterest']);
        $I->seeResponseContains('The resource has been deleted');
    }
}
