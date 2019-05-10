<?php


namespace Tests\functional\MarketingBundle\Controller;

use FunctionalTester;
use phpDocumentor\Reflection\Types\Static_;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InvitationControllerCest
 * @package Tests\functional\MarketingBundle\Controller
 */
class InvitationControllerCest
{
    const TEST_URI = '/invitation';

    protected $createInvitationId;

    /**
     * @param FunctionalTester $I
     * @throws \Exception
     */
    public function tryCGetInvitationOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET(self::TEST_URI);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
        $this->createInvitationId = $I->grabDataFromResponseByJsonPath('$.data..id')[0];
    }

    /**
     * @param FunctionalTester $I
     */
    public function testCreateInvitation(FunctionalTester $I)
    {
        $dataInvitation =  '{
        "campaignEvent":1, 
        "name":"invitation1", 
        "description": "test_description", 
        "teaser": "test_teaser", 
        "mailto": "test_mailto", 
        "pathDesktop": "test_pathDesktop", 
        "pathTablet": "test_pathTablet", 
        "pathMobile": "test_pathMobile", 
        "status": 1
        }';

        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendPOST(self::TEST_URI.'/', $dataInvitation);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"name":"invitation1"');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryPutInvitationOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $dataInvitation =  '{
        "campaignEvent":1, 
        "name":"invitation2", 
        "description": "test_description", 
        "teaser": "test_teaser", 
        "mailto": "test_mailto", 
        "pathDesktop": "test_pathDesktop", 
        "pathTablet": "test_pathTablet", 
        "pathMobile": "test_pathMobile", 
        "status": 1
        }';

        $I->sendPUT(self::TEST_URI.'/' . $this->createInvitationId, $dataInvitation);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"name":"invitation2"');
    }
}
