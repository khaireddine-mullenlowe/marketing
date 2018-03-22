<?php

namespace OfferBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class OfferControllerCest
{
    public function tryPostOffer(\FunctionalTester $I)
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
                    "subtitle": "Sous titre de test",
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
}