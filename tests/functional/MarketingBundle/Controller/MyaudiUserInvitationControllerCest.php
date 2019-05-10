<?php


namespace Tests\functional\MarketingBundle\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MyaudiUserInvitationControllerCest
 * @package Tests\functional\MarketingBundle\Controller
 */
class MyaudiUserInvitationControllerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryCGetMyaudiUserInvitationOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/invitation-user/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }

    public function tryPostMyaudiUserInvitationOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $data = '{"myaudiUserId":2, "invitation": 1}';

        $I->sendPOST('/invitation-user/', $data);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
    }

    public function tryDeleteMyaudiUserInvitationOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendDELETE('/invitation-user/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['context' => 'MyaudiUserInvitation']);
        $I->seeResponseContains('The resource has been deleted');
    }
}
