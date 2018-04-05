<?php

namespace OfferBundle\Controller;


use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use OfferBundle\Entity\OfferFunding;
use OfferBundle\Form\OfferFundingType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * Class OfferFundingController
 * @package OfferBundle\Controller
 *
 */
class OfferFundingController extends MullenloweRestController
{
    const CONTEXT = 'OfferFunding';

    /**
     * @Rest\Post("/funding")
     *
     * @param Request $request
     * @return View
     *
     * @SWG\Post(
     *     path="/",
     *     summary="Create a funding offer.",
     *     operationId="createOfferFunding",
     *     tags={"Offer Funding"},
     *     @SWG\Parameter(
     *         name="offerFunding",
     *         in="body",
     *         required=true,
     *         description="OfferFunding offer example",
     *         @SWG\Schema(ref="#/definitions/OfferFunding")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="OfferFunding created",
     *         @SWG\Schema(ref="#/definitions/OfferFundingComplete")
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
        if ($request->request->count() === 0 || !$request->request->has('funding')) {
            throw new BadRequestHttpException(self::CONTEXT,'Input data are empty.');
        }

        $data = $request->request->get('funding');
        $funding = new OfferFunding();
        $form = $this->createForm(OfferFundingType::class, $funding);
        $form->submit($data);
        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid.");
        }

        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($funding);
        $em->flush();

        return $this->createView($funding);
    }

}