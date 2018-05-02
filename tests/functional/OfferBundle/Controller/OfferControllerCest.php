<?php

namespace OfferBundle\Tests\Controller;

use DateInterval;
use DateTime;
use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

class OfferControllerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryCGetOffer(FunctionalTester $I) {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/offer/partner?category=aftersale&partnersIds=1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Offer');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryGetOffersWithoutCategory(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');

        $I->sendGET('/offer/partner');
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Empty category');
    }


    /**
     * @param FunctionalTester $I
     */
    public function tryPostOfferAftersale(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "partnerId": "1",
                    "subtype": "1",
                    "details": "Détail de test",
                    "startDate": "'.$date->add(new DateInterval('P1D'))->format('Y-m-d').'",
                    "endDate": "'.$date->add(new DateInterval('P30D'))->format('Y-m-d').'",
                    "visual": "image_de_test.png",
                    "title": "Titre de test",
                    "description": "Description de test",
                    "terms": "ML de test",
                    "agreements": "1",
                    "discountSimple": "100",
                    "discountDouble": "",
                    "discountTriple": ""
                },
                "terms": {
                    "km": "30000"
                }
            }
        ';

        $I->sendPOST('/offer/partner/', $data);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Offer');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryPostOfferSale(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "partnerId": "1",
                    "subtype": "4",
                    "startDate": "'.$date->add(new DateInterval('P1D'))->format('Y-m-d').'",
                    "endDate": "'.$date->add(new DateInterval('P30D'))->format('Y-m-d').'",
                    "visual": "image_de_test.png",
                    "xPosition": "0",
                    "yPosition": "20",
                    "title": "Titre de test",
                    "description": "Description de test",
                    "terms": "ML de test",
                    "agreements": "1",
                    "monthly": "100",
                    "modelId": "12"
                },
                "terms": {
                    "monthNumber": "30",
                    "maximumKm": "50000",
                    "partnerName": "Concession PONEY",
                    "advancePayment": "5000.00",
                    "monthly": "499.99",
                    "modelName": "Audi A5 Sportback S Line",
                    "engine": "V8 3.2",
                    "options": "Vitre teintée, jantes aliage",
                    "rangeName": "A5",
                    "mgpMin": "3.2",
                    "mgpMax": "5.8",
                    "co2EmissionMin": "5.9",
                    "co2EmissionMax": "15.2",
                    "priceDate": "2017-09-01"
                }
            }
        ';

        $I->sendPOST('/offer/partner/', $data);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Offer');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryPostOfferBadSubtype(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "partnerId": "1",
                    "subtype": "0",
                    "startDate": "'.$date->add(new DateInterval('P1D'))->format('Y-m-d').'",
                    "endDate": "'.$date->add(new DateInterval('P30D'))->format('Y-m-d').'",
                    "visual": "image_de_test.png",
                    "xPosition": "0",
                    "yPosition": "20",
                    "title": "Titre de test",
                    "description": "Description de test",
                    "terms": "ML de test",
                    "agreements": "1",
                    "monthly": "100",
                    "modelId": "12"
                }
            }
        ';

        $I->sendPOST('/offer/partner/', $data);
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
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "partnerId": "1",
                    "subtype": "1",
                    "startDate": "'.$date->add(new DateInterval('P1D'))->format('Y-m-d').'",
                    "endDate": "'.$date->add(new DateInterval('P30D'))->format('Y-m-d').'",
                },
                "terms: {
                    "km": "30000"
                }
            }
        ';

        $I->sendPOST('/offer/partner/', $data);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Invalid');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryPatchOffer(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "id": "1",
                    "subtype": "1",
                    "endDate": "'.$date->add(new DateInterval('P34D'))->format('Y-m-d').'",
                    "description": "Description de test 2",
                    "visual": "image_de_test_2.png"
                }
            }
        ';

        $I->sendPATCH('/offer/partner/', $data);
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
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "id": "1",
                    "subtype": "2",
                    "endDate": "'.$date->add(new DateInterval('P30D'))->format('Y-m-d').'",
                    "description": "Description de test 2",
                    "visual": "image_de_test_2.png"
                }
            }
        ';

        $I->sendPATCH('/offer/partner/', $data);
        $I->seeResponseCodeIs(Response::HTTP_INTERNAL_SERVER_ERROR);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Invalid Offer');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryAddContactToOffer(FunctionalTester $I)
    {
        $data = '
            {
                "myaudiUserId": 2,
                "id": 1,
                "subtype": 1
            }
        ';

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/offer/partner/contact', $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('data":0');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryAddContactToOfferExist(FunctionalTester $I)
    {
        $data = '
            {
                "myaudiUserId": 1,
                "id": 1,
                "subtype": 1
            }
        ';

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/offer/partner/contact', $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('data":1');
    }
}
