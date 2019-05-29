<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CampaignEventControlerCest
 * @package MarketingBundle\tests\Controller
 */
class CampaignEventControlerCest
{
    protected static $jsonData = <<<HEREDOC
{  
   "name":"CampaignEvent",
   "description":"CampaignEvent description",
   "descriptionEvent":"CampaignEvent description",
   "descriptionTarget":"CampaignEvent description",
   "startDate":"2019-05-15",
   "endDate":"2019-05-31",
   "waitingList":0,
   "eventType":1,
   "status":1,
   "legacyId":75621
}
HEREDOC;

    public function testPostCampaignEvent(FunctionalTester $I)
    {
        $this->requestJson($I,201, 'POST', '/campaign-event/', [], [], [], static::$jsonData);
        $I->seeResponseContainsJson(['context' => 'CampaignEvent']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testPostCampaignEvent
     */
    public function testPutCampaignEvent(FunctionalTester $I)
    {
        $this->requestJson($I,200, 'PUT', '/campaign-event/1', [], [], [], static::$jsonData);
        $I->seeResponseContainsJson(['context' => 'CampaignEvent']);
        $I->seeResponseContains('data');
    }

    /**
     * @depends testPutCampaignEvent
     */
    public function testGetCampaignEvent(FunctionalTester $I)
    {
        $this->requestJson($I,200, 'GET', '/campaign-event/1');
        $I->seeResponseContainsJson(['context' => 'CampaignEvent']);
        $I->seeResponseContains('data');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryGetCampaignEventKo(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/campaign-event/2');
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCGetCampaignEventOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/campaign-event');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }

    protected function requestJson(FunctionalTester $I, $expectedStatusCode, $method, $uri, $parameters = [], $files = [], $server = [], $content = [])
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->{"send".$method}($uri, $content, $parameters);
        $I->seeResponseCodeIs($expectedStatusCode);
        $I->seeResponseIsJson();
    }
}
