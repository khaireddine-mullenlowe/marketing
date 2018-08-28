<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class MyaudiUserMarketingObjectiveControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryCGetMarketingObjectiveOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/myaudi-user-marketing-objective/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }

    public function tryPostMyaudiUserMarketingObjectiveOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":0, "marketingObjective":1}';

        $I->sendPOST('/myaudi-user-marketing-objective/', $data);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"marketingObjective":{"id":1');
    }

    public function tryPostMyaudiUserMarketingObjectiveKo(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":1}';

        $I->sendPOST('/myaudi-user-marketing-objective/', $data);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('This value should not be null');
    }

    public function tryPutMyaudiUserMarketingObjectiveOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":1, "marketingObjective":1}';

        $I->sendPUT('/myaudi-user-marketing-objective/', $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"marketingObjective":{"id":1');
    }

    public function tryPutMyaudiUserMarketingObjectiveKo(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":0, "marketingObjective":1}';

        $I->sendPUT('/myaudi-user-marketing-objective/', $data);
        $I->seeResponseCodeIs(Response::HTTP_INTERNAL_SERVER_ERROR);
        $I->seeResponseIsJson();
        $I->seeResponseContains('myaudiUserMarketingObjective Not Found');
    }
}
