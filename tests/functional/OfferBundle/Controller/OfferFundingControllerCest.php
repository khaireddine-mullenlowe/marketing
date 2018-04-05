<?php

namespace Tests\functional\OfferBundle\Controller;

use FunctionalTester;
use DateTime;
use DateInterval;
use Symfony\Component\HttpFoundation\Response;

class OfferFundingControllerCest
{
    /**
     * @param FunctionalTester $I
     */
    public function tryPostOfferFunding(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "funding": {
                    "type": "NATIONAL",
                    "modelId": "10",
                    "label": "Label de test",
                    "rangeId": 10,
                    "price": 100,
                    "withContribution": 1,
                    "guaranteed": 0,
                    "maintained": 0,
                    "details": "Détails de test",
                    "legalNotice": "Mentions légales",
                    "startDate": "' . (new DateTime())->add(new DateInterval('P1D'))->format('Y-m-d') . '",
                    "endDate": "' . (new DateTime())->add(new DateInterval('P10D'))->format('Y-m-d') . '",
                    "visual": "Visuel de test",
                    "active": 1
                }
            }
        ';

        $I->sendPOST('/offer/funding', $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferFunding');
    }


    /**
     * @param FunctionalTester $I
     */
    public function tryPostOfferFundingIncomplete(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "funding": {
                    "type": "NATIONAL",
                    "modelId": "10",
                    "label": "Label de test",
                    "rangeId": 10,
                    "price": 100,
                    "withContribution": 1,
                    "guaranteed": 0,
                    "maintained": 0,
                    "active": 1
                }
            }
        ';

        $I->sendPOST('/offer/funding', $data);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Invalid Field');
    }
}