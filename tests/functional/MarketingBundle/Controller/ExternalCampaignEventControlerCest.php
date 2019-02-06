<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ExternalCampaignEventControlerCest
 * @package MarketingBundle\tests\Controller
 */
class ExternalCampaignEventControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryGetExternalCampaignEventOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/external-campaign-event/1');
        $I->seeResponseIsJson();
        $I->seeResponseContains('"id":1');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryGetExternalCampaignEventKo(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/external-campaign-event/2');
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCGetExternalCampaignEventOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/external-campaign-event');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }
}
