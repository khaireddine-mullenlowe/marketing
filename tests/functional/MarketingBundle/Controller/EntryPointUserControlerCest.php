<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EntryPointUserControlerCest
 * @package MarketingBundle\tests\Controller
 */
class EntryPointUserControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryCGetEntryPointUserOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/entry-point-user/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }
}
