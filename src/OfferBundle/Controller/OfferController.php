<?php

namespace OfferBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use InvalidArgumentException;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use OfferBundle\Entity\OfferAftersale;
use OfferBundle\Entity\OfferAftersaleTermsProperty;
use OfferBundle\Entity\OfferSale;
use OfferBundle\Entity\OfferSecondhandCarTermsProperty;
use OfferBundle\Entity\OfferNewCarTermsProperty;
use OfferBundle\Form\OfferAftersaleTermsType;
use OfferBundle\Form\OfferAftersaleType;
use OfferBundle\Form\OfferNewCarTermsType;
use OfferBundle\Form\OfferSaleType;
use OfferBundle\Form\OfferSecondhandCarTermsType;
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
        'aftersale'     => [
            'name'         => 'Aftersale',
            'entity'       => OfferAftersale::class,
            'formType'     => OfferAftersaleType::class,
            'formTerms'    => OfferAftersaleTermsType::class,
            'repository'   => 'OfferBundle:OfferAftersale',
            'termsEntity'  => OfferAftersaleTermsProperty::class,
        ],
        'secondhandcar' => [
            'name'         => 'SecondHandCar',
            'entity'       => OfferSale::class,
            'formType'     => OfferSaleType::class,
            'formTerms'    => OfferSecondhandCarTermsType::class,
            'repository'   => 'OfferBundle:OfferSale',
            'termsEntity'  => OfferSecondhandCarTermsProperty::class,
        ],
        'newcar'        => [
            'name'         => 'NewCar',
            'entity'       => OfferSale::class,
            'formType'     => OfferSaleType::class,
            'formTerms'    => OfferNewCarTermsType::class,
            'repository'   => 'OfferBundle:OfferSale',
            'termsEntity'  => OfferNewCarTermsProperty::class,
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
     *         response="200",
     *         description="Offer created - Example for aftersale",
     *         @SWG\Schema(ref="#/definitions/OfferAftersaleComplete")
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

        if (!empty($dataInput['terms'])) {
            $termsProperty = new $type['termsEntity'];
            $formTerms = $this->createForm($type['formTerms'], $termsProperty);
            $formTerms->submit($dataInput['terms']);

            if (!$formTerms->isSubmitted()) {
                throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for terms");
            } elseif (!$formTerms->isValid()) {
                return $this->view($formTerms);
            }
        } else {
            throw new InvalidArgumentException('Invalid terms');
        }

        $offer = new $type['entity']($subtype);

        $form = $this->createForm($type['formType'], $offer);

        $form->submit($offerData);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for offer");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $offer->setTermsProperty($termsProperty);
        $termsProperty->setOffer($offer);

        $em = $this->getDoctrine()->getManager();
        $em->persist($offer);
        $em->flush();

        return $this->createView($offer);
    }

    /**
     * @Rest\Patch("/")
     *
     * @param Request $request
     * @return View
     *
     * @SWG\Patch(
     *     path="/offer/",
     *     summary="Update an offer",
     *     operationId="updateOffer",
     *     tags={"offer"},
     *     @SWG\Parameter(
     *         name="offer",
     *         in="body",
     *         required=true,
     *         description="Offer",
     *         @SWG\Schema(ref="#/definitions/OfferUpdate")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="offer updated - Example for sale",
     *         @SWG\Schema(ref="#/definitions/OfferSaleComplete")
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
        $dataInput = $request->request->all();

        $offerData = $dataInput['offer'];

        if (!empty($offerData['subtype'])) {
            $doctrine = $this->getDoctrine();
            $subtype = $doctrine->getRepository("OfferBundle:OfferSubtype")->find(intval($offerData['subtype']));
        }

        if (empty($subtype)) {
            throw new InvalidArgumentException('Invalid OfferSubtype');
        }

        $type = self::OFFERTYPE[strtolower($subtype->getType()->getCategory())];

        $offer = $doctrine->getRepository($type['repository'])->findOneBy([
            'id' => $offerData['id'],
            'subtype' => $offerData['subtype'],
        ]);

        if (empty($offer)) {
            throw new InvalidArgumentException('Invalid Offer');
        }

        $offerData['terms'] = $this->get('offer.terms')->generateUpdatedTerms($offer, $offerData['endDate']);

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
}
