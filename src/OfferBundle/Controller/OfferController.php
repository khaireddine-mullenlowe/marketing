<?php

namespace OfferBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use InvalidArgumentException;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use OfferBundle\Entity\OfferAftersale as Aftersale;
use OfferBundle\Entity\OfferSale as Sale;
use OfferBundle\Form\OfferAftersaleType;
use OfferBundle\Form\OfferSaleType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Swagger\Annotations as SWG;

/**
 * Class OfferController
 */
class OfferController extends MullenloweRestController
{
    const CONTEXT = 'Offer';

    /**
     * @Rest\Get("/partner/{partnerId}")
     * @Rest\View()
     *
     * @param int $partnerId
     * @return View
     *
     * @SWG\Get(
     *     path="offer/partner/{partnerId}",
     *     summary="Get offers for a partner",
     *     operationId="getOffers",
     *     tags={"offer"},
     *     @SWG\Parameter(
     *         name="partner_id",
     *         in="query",
     *         type="integer",
     *         required="true",
     *         description="Partner Id"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="offers",
     *         @SWG\Schema(ref="#/definitions/Offer")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function getAction(int $partnerId)
    {
        $em = $this->getDoctrine();
        $offers = $em->getRepository("OfferBundle:OfferAftersale")->findBy(['partner' => $partnerId]);

        return $this->createView($offers);
    }

    /**
     * @Rest\Post("/")
     *
     * @param Request $request
     * @return View
     *
     * @SWG\Post(
     *     path="/offer/",
     *     summary="Create an offer, according to the subtype, the offer is an aftersale or sale offer",
     *     operationId="createOffer",
     *     tags={"offer"},
     *     @SWG\Parameter(
     *         name="offer",
     *         in="body",
     *         required="true",
     *         description="Partner Id",
     *         @SWG\Schema(ref="#/definitions/Offer")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="offers",
     *         @SWG\Schema(ref="#/definitions/Offer")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function postAction(Request $request)
    {
        $dataInput = $request->request->all();

        $offerData = $dataInput['offer'];

        if (!empty($offerData['subtype'])) {
            $em = $this->getDoctrine();
            $subtype = $em->getRepository("OfferBundle:OfferSubtype")->find($offerData['subtype']);
        }

        if (empty($subtype)) {
            throw new \InvalidArgumentException('Invalid OfferSubtype');
        }

        $type = $subtype->getType()->getCategory();

        if ($type === 'AFTERSALE') {
            $offerClass = Aftersale::class;
            $offerFormTypeClass = OfferAftersaleType::class;
        } elseif ($type === 'SECONDHANDCAR' || $type === 'NEWCAR') {
            $offerClass = Sale::class;
            $offerFormTypeClass = OfferSaleType::class;
        } else {
            throw new InvalidArgumentException('Invalid offerType');
        }

        $offer = new $offerClass($subtype);

        $form = $this->createForm($offerFormTypeClass, $offer);

        $form->handleRequest($request);
        $form->submit($offerData);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for offer");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($offer);
        $em->flush();

        return $this->createView($offer);
    }
}
