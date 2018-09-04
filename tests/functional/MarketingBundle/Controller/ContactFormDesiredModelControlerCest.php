<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactFormDesiredModelControlerCest
 * @package MarketingBundle\tests\Controller
 */
class ContactFormDesiredModelControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryCGetContactFormDesiredModelOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/contact-form-desired-model/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }
}
