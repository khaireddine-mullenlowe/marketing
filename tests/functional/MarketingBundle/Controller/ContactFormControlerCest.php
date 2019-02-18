<?php

namespace MarketingBundle\tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactFormControlerCest
 * @package MarketingBundle\tests\Controller
 */
class ContactFormControlerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryGetContactFormOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/contact-form/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"id":1');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryGetContactFormKo(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/contact-form/2');
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCGetContactFormOk(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/contact-form');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"total":1');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryImportContactFormKo(FunctionalTester $I) {
        $I->sendPOST('/contact-form/import/', ['inline' => 0], ['file' => codecept_data_dir('test.sql')]);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryImportContactFormOk(FunctionalTester $I) {
        $source = __DIR__.'/../Resources/template-contactform.xlsx';
        $dest = codecept_data_dir().'/template-contactform.xlsx';
        copy($source, $dest);

        $I->sendPOST('/contact-form/import/', ['inline' => 0], ['file' => codecept_data_dir('template-contactform.xlsx')]);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"operation_details":"201901_NOUVELLE_Q3_Audi.fr_classique"');
        $I->seeResponseContains('"operation_details":"201901_NOUVELLE_Q3_display_webcallback"');
        $I->seeResponseContains('"name":"201901_NOUVELLE_Q3"');
        $I->seeResponseContains('"name":"202001_NOUVELLE_Q3"');
    }
}
