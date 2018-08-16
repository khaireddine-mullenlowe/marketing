<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class InterestUserControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryCGetInterestUserOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/interest-user/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }

    public function tryPostInterestUserOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"userId":2, "interest": 1}';

        $I->sendPOST('/interest-user/', $data);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
    }

    public function tryDeleteInterestUserObjectiveOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendDELETE('/interest-user/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'InterestUser']);
        $I->seeResponseContains('The resource has been deleted');
    }
}
