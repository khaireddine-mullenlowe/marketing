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

/**
 * Class OfferController
 */
class OfferController extends MullenloweRestController
{
    const CONTEXT = 'Offer';

    /**
     * @Rest\Get("/partner/{partnerId}")
     *
     * @param int $partnerId
     * @return View
     */
    public function getAction(int $partnerId)
    {
        $em = $this->getDoctrine();
        $offers = ($em->getRepository("OfferBundle:OfferAftersale"))->findBy(['partner' => $partnerId]);

        return $this->createView($offers);
    }

    /**
     * @Rest\Post("/new")
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $dataInput = $request->request->all();

        $subtype = $this->get('offer.aftersale')->checkSubtype($dataInput);

        if ($subtype['type'] === 'AFTERSALE') {
            $offerClass = Aftersale::class;
            $offerFormTypeClass = OfferAftersaleType::class;
        } elseif ($subtype['type'] === 'SECONDHANDCAR' || $subtype['type'] === 'NEWCAR') {
            $offerClass = Sale::class;
            $offerFormTypeClass = OfferSaleType::class;
        } else {
            throw new InvalidArgumentException('Invalid offerType');
        }

        $offer = new $offerClass($subtype['subtype']);

        $form = $this->createForm($offerFormTypeClass, $offer);

        $form->handleRequest($request);
        $form->submit($dataInput);

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
