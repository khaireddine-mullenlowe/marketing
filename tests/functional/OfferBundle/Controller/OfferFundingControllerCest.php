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
                    "type": "national",
                    "modelId": "10",
                    "name": "Label de test",
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
                    "status": 1
                }
            }
        ';

        $I->sendPOST('/offer/funding', $data);
        $I->seeResponseCodeIs(Response::HTTP_CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferFunding');
    }

    public function tryPostOfferFundingIncomplete(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "funding": {
                    "type": "national",
                    "modelId": "10",
                    "name": "Label de test",
                    "rangeId": 10,
                    "price": 100,
                    "withContribution": 1,
                    "guaranteed": 0,
                    "maintained": 0,
                    "status": 1
                }
            }
        ';

        $I->sendPOST('/offer/funding', $data);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Invalid Field');
    }

    public function tryPostOfferFundingInvalid(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $data = '
            {
                "funding": {
                    "type": "national",
                    "modelId": "10",
                    "name": "Label de test",
                    "rangeId": 10,
                    "price": 100,
                    "withContribution": 1,
                    "guaranteed": 0,
                    "maintained": 0,
                    "details": "Détails de test",
                    "legalNotice": "Mentions légales",
                    "startDate": "' . (new DateTime())->sub(new DateInterval('P1D'))->format('Y-m-d') . '",
                    "endDate": "' . (new DateTime())->add(new DateInterval('P10D'))->format('Y-m-d') . '",
                    "visual": "Visuel de test",
                    "status": 1
                }
            }
        ';

        $I->sendPOST('/offer/funding', $data);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('StartDate must be higher than today');
    }

    public function tryGetOfferFunding(FunctionalTester $I)
    {
        $I->sendGET('/offer/funding/1');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferFunding');
        $I->seeResponseContains('modelId');
        $I->seeResponseContains('rangeId');
    }

    public function tryGetOfferFundingFails(FunctionalTester $I)
    {
        $I->sendGET('/offer/funding/1999');
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferFunding {1999} not found');
    }

    public function trySearch(FunctionalTester $I)
    {
        $I->sendGET('/offer/funding/search?q=myFundingOffer');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseContains('pagination');
        $I->seeResponseContains('data');
        $I->seeResponseContains('1200.15');
    }

    public function tryPatchOfferFundingEmptyData(FunctionalTester $I)
    {
        $I->sendPATCH('/offer/funding/1999');
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('Input data are empty');
    }

    public function tryPatchOfferFundingNotFound(FunctionalTester $I)
    {
        $data = '
            {
                "funding": {
                    "type": "local"
                }
            }
        ';

        $I->sendPATCH('/offer/funding/1999', $data);
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseIsJson();
        $I->seeResponseContains('OfferFunding {1999} not found');
    }

    public function tryPatchOfferFundingOk(FunctionalTester $I)
    {
        $data = '
            {
                "funding": {
                    "type": "local"
                }
            }
        ';

        $I->sendPATCH('/offer/funding/1', $data);
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"local"');
    }

    public function tryCgetOfferFundingOk(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/offer/funding');
        $I->seeResponseCodeIs(Response::HTTP_OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains('pagination');
        $I->seeResponseContains('data');
    }
}