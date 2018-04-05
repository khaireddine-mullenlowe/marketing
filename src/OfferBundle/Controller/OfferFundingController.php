<?php

namespace OfferBundle\Controller;


use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use OfferBundle\Entity\OfferFunding;
use OfferBundle\Form\OfferFundingType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
<<<<<<< HEAD
use Symfony\Component\HttpFoundation\Response;
=======
>>>>>>> Funding offer : Create

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
<<<<<<< HEAD
     * @return \FOS\RestBundle\View\View
=======
     * @return View
>>>>>>> Funding offer : Create
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
<<<<<<< HEAD
     *         response="201",
=======
     *         response="200",
>>>>>>> Funding offer : Create
     *         description="OfferFunding created",
     *         @SWG\Schema(ref="#/definitions/OfferFundingComplete")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
<<<<<<< HEAD
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Bad request",
     *         @SWG\Schema(ref="#/definitions/Error")
=======
>>>>>>> Funding offer : Create
     *     )
     * )
     */
    public function postAction(Request $request)
    {
        if ($request->request->count() === 0 || !$request->request->has('funding')) {
<<<<<<< HEAD
            throw new BadRequestHttpException(self::CONTEXT, 'Input data are empty.');
=======
            throw new BadRequestHttpException(self::CONTEXT,'Input data are empty.');
>>>>>>> Funding offer : Create
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

<<<<<<< HEAD
        return $this->createView($funding, Response::HTTP_CREATED);
=======
        return $this->createView($funding);
>>>>>>> Funding offer : Create
    }

}