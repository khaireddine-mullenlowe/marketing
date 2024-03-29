<?php

namespace OfferBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use InvalidArgumentException;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use OfferBundle\Entity\OfferAftersale;
use OfferBundle\Entity\OfferAftersaleMyaudiUser;
use OfferBundle\Entity\OfferSale;
use OfferBundle\Entity\OfferSaleMyaudiUser;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use OfferBundle\Enum\OfferEnum;

/**
 * Class OfferController
 * @Route("partner")
 */
class OfferController extends MullenloweRestController
{
    const CONTEXT = 'Offer';

    const SERVICING = 'Entretien';

    /**
     * @Rest\Get("/")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @param Request $request
     * @return View
     *
     * @SWG\Get(
     *     path="/offer/partner",
     *     summary="Get offers for a partner",
     *     operationId="getOffers",
     *     tags={"Offer"},
     *     @SWG\Parameter(
     *         name="myaudiUserId",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="Myaudi User ID"
     *     ),
     *     @SWG\Parameter(
     *         name="category",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="newcar or aftersale - Required if myaudiUserId is null"
     *     ),
     *     @SWG\Parameter(
     *         name="partnerIds",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="Partner Ids splited by a comma"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Offers - Example for aftersale",
     *         @SWG\Definition(ref="#/definitions/OfferAftersaleContextMulti")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Empty category for a request by partner",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function cgetAction(Request $request)
    {
        $myaudiUserId = $request->query->get('myaudiUserId');
        if (!empty($myaudiUserId)) {
            $doctrine = $this->getDoctrine();
            $aftersaleOffers = $doctrine
                ->getRepository(OfferEnum::OFFERTYPE['aftersale']['repository'])
                ->findByMyaudiUser($myaudiUserId);

            $saleOffers = $doctrine
                ->getRepository(OfferEnum::OFFERTYPE['newcar']['repository'])
                ->findByMyaudiUser($myaudiUserId);

            $offers = array_merge($aftersaleOffers, $saleOffers);
        } else {
            $category = $request->query->get('category');

            if (empty($category)) {
                throw new BadRequestHttpException(self::CONTEXT, 'Empty category');
            }

            $type = OfferEnum::OFFERTYPE[$category];

            $em = $this->getDoctrine();
            $offers = $em->getRepository($type['repository'])->findOffersSinceAYear($request->query->get('partnerIds'));
        }

        return $this->createView($offers);
    }

    /**
     * @Rest\Post("/")
     *
     * @param Request $request
     * @return View
     *
     * @SWG\Post(
     *     path="/offer/partner",
     *     summary="Create an offer, according to the subtype, the offer is an aftersale or sale offer",
     *     operationId="createOffer",
     *     tags={"Offer"},
     *     @SWG\Parameter(
     *         name="offer aftersale",
     *         in="body",
     *         required=true,
     *         description="Offer aftersale example",
     *         @SWG\Schema(ref="#/definitions/OfferAftersale")
     *     ),
     *     @SWG\Parameter(
     *         name="offer sale - SecondhandCar",
     *         in="body",
     *         required=true,
     *         description="Offer sale secondhand example",
     *         @SWG\Schema(ref="#/definitions/OfferSecondhandCar")
     *     ),
     *     @SWG\Parameter(
     *         name="offer sale - NewCar",
     *         in="body",
     *         required=true,
     *         description="Offer sale newcar example",
     *         @SWG\Schema(ref="#/definitions/OfferNewCar")
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Offer created - Example for aftersale",
     *         @SWG\Definition(ref="#definitions/OfferAftersaleContext")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Bad Subtype or Invalid terms",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function postAction(Request $request)
    {
        $offerData = $request->request->get('offer');
        $termsData = $request->request->get('terms');

        if (!empty($offerData['subtype'])) {
            $em = $this->getDoctrine();
            $subtype = $em->getRepository("OfferBundle:OfferSubtype")->find(intval($offerData['subtype']));
        }

        if (empty($subtype)) {
            throw new InvalidArgumentException('Invalid OfferSubtype');
        }

        $category = strtolower($subtype->getType()->getCategory());

        if (empty(OfferEnum::OFFERTYPE[$category])) {
            throw new InvalidArgumentException('Invalid Category');
        }

        $type  = OfferEnum::OFFERTYPE[$category];

        $offer = new $type['entity']($subtype);

        $form = $this->createForm($type['formType'], $offer);

        $form->submit($offerData);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for offer");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        if ($type['name'] !== OfferEnum::OFFERTYPE['aftersale']['name'] ||
            (
                $type['name'] === OfferEnum::OFFERTYPE['aftersale']['name']
                && $subtype->getType()->getName() === self::SERVICING
                && $subtype->getRank() < 4
            )
        ) {
            if (!empty($termsData)) {
                $termsProperty = new $type['termsEntity'];
                $formTerms = $this->createForm($type['formTerms'], $termsProperty);
                $formTerms->submit($termsData);

                if (!$formTerms->isSubmitted()) {
                    throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for terms");
                } elseif (!$formTerms->isValid()) {
                    return $this->view($formTerms);
                }
            } else {
                throw new InvalidArgumentException('Invalid terms');
            }

            $offer->setTermsProperty($termsProperty);

            $termsProperty->setOffer($offer);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($offer);
        $em->flush();

        return $this->createView($offer, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Patch("/")
     *
     * @param Request $request
     * @return View
     *
     * @SWG\Patch(
     *     path="/offer/partner",
     *     summary="Update an offer",
     *     operationId="updateOffer",
     *     tags={"Offer"},
     *     @SWG\Parameter(
     *         name="offer",
     *         in="body",
     *         required=true,
     *         description="Offer",
     *         @SWG\Schema(ref="#/definitions/OfferUpdate")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Offer updated - Example for sale",
     *         @SWG\Definition(ref="#definitions/OfferSaleContext")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Bad Subtype or Invalid offer",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function patchAction(Request $request)
    {
        $offerData = $request->request->get('offer');

        if (!empty($offerData['subtype'])) {
            $doctrine = $this->getDoctrine();
            $subtype = $doctrine->getRepository("OfferBundle:OfferSubtype")->find(intval($offerData['subtype']));
        }

        if (empty($subtype)) {
            throw new InvalidArgumentException('Invalid OfferSubtype');
        }

        $category = strtolower($subtype->getType()->getCategory());

        if (empty(OfferEnum::OFFERTYPE[$category])) {
            throw new InvalidArgumentException('Invalid Category');
        }

        $type = OfferEnum::OFFERTYPE[strtolower($subtype->getType()->getCategory())];

        $offer = $doctrine->getRepository($type['repository'])->findOneBy([
            'id' => $offerData['id'],
            'subtype' => $offerData['subtype'],
        ]);

        if (empty($offer)) {
            throw new InvalidArgumentException('Invalid Offer');
        }

        $form = $this->createForm($type['formType'], $offer);

        $form->submit($offerData, false);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for offer");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $doctrine->getManager();
        $em->persist($offer);
        $em->flush();

        return $this->createView($offer);
    }

    /**
     * @Rest\POST("/contact")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @SWG\Post(
     *     path="/offer/partner/contact",
     *     summary="Add contacts to an offer",
     *     operationId="addContactsToOffer",
     *     tags={"Offer"},
     *     @SWG\Parameter(
     *         name="myaudiUser",
     *         in="body",
     *         required=true,
     *         description="List of ID Myaudi User, ID Subtype, ID Offer",
     *         @SWG\Schema(ref="#/definitions/MyaudiUsersOffer")
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Ok",
     *         @SWG\Definition(ref="#definitions/OfferAftersaleMyaudiUserContext")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Bad Subtype or Invalid offer",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param Request $request
     * @return View
     */
    public function addContactToOfferAction(Request $request)
    {
        $data = $request->request->all();

        if (!empty($data['subtype'])) {
            $doctrine = $this->getDoctrine();
            $subtype = $doctrine->getRepository("OfferBundle:OfferSubtype")->find(intval($data['subtype']));
        }

        if (empty($subtype)) {
            throw new InvalidArgumentException('Invalid OfferSubtype');
        }

        $category = strtolower($subtype->getType()->getCategory());

        if (empty(OfferEnum::OFFERTYPE[$category])) {
            throw new InvalidArgumentException('Invalid Category');
        }

        $type = OfferEnum::OFFERTYPE[$category];

        /** @var OfferAftersale|OfferSale $offer */
        $offer = $doctrine->getRepository($type['repository'])->findOneBy([
            'id' => $data['id'],
            'subtype' => $data['subtype'],
        ]);

        if (empty($offer)) {
            throw new InvalidArgumentException('Invalid Offer');
        }

        foreach ($data['myaudiUserIds'] as $val) {
            $myaudiUser = $doctrine
                ->getRepository($type['myaudiUserRepository'])
                ->findBy(['offer' => $data['id'], 'myaudiUserId' => $val]);

            if (empty($myaudiUser)) {
                /** @var OfferAftersaleMyaudiUser|OfferSaleMyaudiUser $myaudiUser */
                $myaudiUser = new $type['myaudiUser']();
                $myaudiUser->setOffer($offer);
                $myaudiUser->setMyaudiUserId($val);
                $doctrine->getManager()->persist($myaudiUser);
            }
        }

        $doctrine->getManager()->flush();

        return $this->createView('', Response::HTTP_CREATED);
    }
}
