<?php

namespace OfferBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use InvalidArgumentException;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
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

    const OFFERTYPE = [
        'aftersale' => [
            'name' => 'AFTERSALE',
            'entity' => \OfferBundle\Entity\OfferAftersale::class,
            'formType' => \OfferBundle\Form\OfferAftersaleType::class,
        ],
        'secondhandcar' => [
            'name' => 'SECONDHANDCAR',
            'entity' => \OfferBundle\Entity\OfferSale::class,
            'formType' => \OfferBundle\Form\OfferSaleType::class,
        ],
        'newcar' => [
            'name' => 'NEWCAR',
            'entity' => \OfferBundle\Entity\OfferSale::class,
            'formType' => \OfferBundle\Form\OfferSaleType::class,
        ],
    ];

    /**
     * @Rest\Get("/partner/{partnerId}")
     * @Rest\View()
     *
     * @param int $partnerId
     * @return View
     *
     * @SWG\Get(
     *     path="/offer/partner/{partnerId}",
     *     summary="Get offers for a partner",
     *     operationId="getOffers",
     *     tags={"offer"},
     *     @SWG\Parameter(
     *         name="partnerId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="Partner Id"
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
     *         required=true,
     *         description="Offer aftersale example",
     *         @SWG\Schema(ref="#/definitions/OfferAftersale")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="offer created",
     *         @SWG\Schema(ref="#/definitions/OfferAftersaleComplete")
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
            $subtype = $em->getRepository("OfferBundle:OfferSubtype")->find(intval($offerData['subtype']));
        }

        if (empty($subtype)) {
            throw new InvalidArgumentException('Invalid OfferSubtype');
        }

        $type = self::OFFERTYPE[strtolower($subtype->getType()->getCategory())];

        $offer = new $type['entity']($subtype);

        $form = $this->createForm($type['formType'], $offer);

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
