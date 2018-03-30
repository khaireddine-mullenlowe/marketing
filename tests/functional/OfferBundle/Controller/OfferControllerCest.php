<?php

namespace OfferBundle\Tests\Controller;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class OfferControllerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryPostOfferAftersale(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "offer": {
                    "partner": "1",
                    "subtype": "1",
                    "details": "Détail de test",
                    "startDate": "2018-05-05",
                    "endDate": "2018-06-06",
                    "visual": "image_de_test.png",
                    "title": "Titre de test",
                    "description": "Description de test",
                    "terms": "ML de test",
                    "agreements": "1",
                    "discountSimple": "100",
                    "discountDouble": "",
                    "discountTriple": ""
                }
            }
        ';

        $I->sendPOST('/offer/', $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Offer');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryPostOfferSale(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "offer": {
                    "partner": "1",
                    "subtype": "4",
                    "startDate": "2018-05-05",
                    "endDate": "2018-06-06",
                    "visual": "image_de_test.png",
                    "xPosition": "0",
                    "yPosition": "20",
                    "title": "Titre de test",
                    "description": "Description de test",
                    "terms": "ML de test",
                    "agreements": "1",
                    "monthly": "100",
                    "model": "12"
                }
            }
        ';

        $I->sendPOST('/offer/', $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Offer');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryPostOfferBadSubtype(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "offer": {
                    "partner": "1",
                    "subtype": "0",
                    "startDate": "2018-05-05",
                    "endDate": "2018-06-06",
                    "visual": "image_de_test.png",
                    "xPosition": "0",
                    "yPosition": "20",
                    "title": "Titre de test",
                    "description": "Description de test",
                    "terms": "ML de test",
                    "agreements": "1",
                    "monthly": "100",
                    "model": "12"
                }
            }
        ';

        $I->sendPOST('/offer/', $data);
        $I->seeResponseCodeIs(Response::HTTP_INTERNAL_SERVER_ERROR);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Invalid OfferSubtype');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryPostOfferInvalid(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "offer": {
                    "partner": "1",
                    "subtype": "1",
                    "startDate": "2018-05-05",
                    "endDate": "2018-06-06"
                }
            }
        ';

        $I->sendPOST('/offer/', $data);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Invalid Field');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryPatchOffer(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "offer": {
                    "id": "1",
                    "subtype": "1",
                    "endDate": "2018-08-08",
                    "description": "Description de test 2",
                    "visual": "image_de_test_2.png"
                }
            }
        ';

        $I->sendPATCH('/offer/', $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Offer');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryPatchOfferBadSubtype(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "offer": {
                    "id": "1",
                    "subtype": "2",
                    "endDate": "2018-08-08",
                    "description": "Description de test 2",
                    "visual": "image_de_test_2.png"
                }
            }
        ';

        $I->sendPATCH('/offer/', $data);
        $I->seeResponseCodeIs(Response::HTTP_INTERNAL_SERVER_ERROR);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Invalid Offer');
    }
}
