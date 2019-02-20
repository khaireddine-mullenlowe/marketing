<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class MyaudiUserMarketingObjectiveControlerCest
{
    /** @var $id */
    protected $id;

    /**
     * @param FunctionalTester $I
     * @throws \Exception
     */
    public function tryCGetMarketingObjectiveOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/myaudi-user-marketing-objective/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
        $this->id = $I->grabDataFromResponseByJsonPath('$.data..id')[0];
    }

    public function tryPostMyaudiUserMarketingObjectiveOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":10,"marketingObjective":1,"isUnsubscribe":false}';

        $I->sendPOST('/myaudi-user-marketing-objective/', $data);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"marketingObjective":{"id":1');
        $I->seeResponseContains('"isUnsubscribe":false');
    }

    public function tryPostMyaudiUserMarketingObjectiveByUpdating(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":1, "marketingObjective":1,"isUnsubscribe":true}';

        $I->sendPOST('/myaudi-user-marketing-objective/', $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"marketingObjective":{"id":1');
        $I->seeResponseContains('"isUnsubscribe":true');
    }

    public function tryPostMyaudiUserMarketingObjectiveKo(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":10}';

        $I->sendPOST('/myaudi-user-marketing-objective/', $data);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('This value should not be null');
    }

    public function tryPutMyaudiUserMarketingObjectiveOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":1, "marketingObjective":1,"isUnsubscribe":false}';

        $I->sendPUT('/myaudi-user-marketing-objective/' . $this->id, $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"marketingObjective":{"id":1');
        $I->seeResponseContains('"isUnsubscribe":false');
    }

    public function tryPutMyaudiUserMarketingObjectiveKo(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":10, "marketingObjectives":1}';

        $I->sendPUT('/myaudi-user-marketing-objective/' . $this->id, $data);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
    }
}
