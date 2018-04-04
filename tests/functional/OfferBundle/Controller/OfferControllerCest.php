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
    public function tryPostOfferAftersale(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "partner": "1",
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
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "partner": "1",
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
                    "model": "12"
                },
                "terms": {
                    "monthNumber": "30",
                    "maximumKm": "50000",
                    "partner": "Concession PONEY",
                    "advancePayment": "5000.00",
                    "monthRentalNumber": "29",
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
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "partner": "1",
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
        $date = new DateTime('now');

        $data = '
            {
                "offer": {
                    "partner": "1",
                    "subtype": "1",
                    "startDate": "'.$date->add(new DateInterval('P1D'))->format('Y-m-d').'",
                    "endDate": "'.$date->add(new DateInterval('P30D'))->format('Y-m-d').'",
                },
                "terms: {
                    "km": "30000"
                }
            }
        ';

        $I->sendPOST('/offer/', $data);
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

        $I->sendPATCH('/offer/', $data);
        $I->seeResponseCodeIs(Response::HTTP_INTERNAL_SERVER_ERROR);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Invalid Offer');
    }
}
