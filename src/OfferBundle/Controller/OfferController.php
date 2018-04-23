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
use OfferBundle\Form\OfferAftersaleTermsPropertyType;
use OfferBundle\Form\OfferAftersaleType;
use OfferBundle\Form\OfferNewCarTermsPropertyType;
use OfferBundle\Form\OfferSaleType;
use OfferBundle\Form\OfferSecondhandCarTermsPropertyType;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class OfferController
 * @Route("partner")
 */
class OfferController extends MullenloweRestController
{
    const CONTEXT = 'Offer';

    const SERVICING = 'Entretien';

    const OFFERTYPE = [
        'aftersale'     => [
            'name'         => 'Aftersale',
            'entity'       => OfferAftersale::class,
            'formType'     => OfferAftersaleType::class,
            'formTerms'    => OfferAftersaleTermsPropertyType::class,
            'repository'   => 'OfferBundle:OfferAftersale',
            'termsEntity'  => OfferAftersaleTermsProperty::class,
        ],
        'secondhandcar' => [
            'name'         => 'SecondHandCar',
            'entity'       => OfferSale::class,
            'formType'     => OfferSaleType::class,
            'formTerms'    => OfferSecondhandCarTermsPropertyType::class,
            'repository'   => 'OfferBundle:OfferSale',
            'termsEntity'  => OfferSecondhandCarTermsProperty::class,
        ],
        'newcar'        => [
            'name'         => 'NewCar',
            'entity'       => OfferSale::class,
            'formType'     => OfferSaleType::class,
            'formTerms'    => OfferNewCarTermsPropertyType::class,
            'repository'   => 'OfferBundle:OfferSale',
            'termsEntity'  => OfferNewCarTermsProperty::class,
        ],
    ];

    /**
     * @Rest\Get("")
     * @Rest\View(serializerGroups={"rest"})
     *
     * @param Request $request
     * @return View

     * @SWG\Get(
     *     path="/offer/partner",
     *     summary="Get offers for a partner",
     *     operationId="getOffers",
     *     tags={"Offer"},
     *     @SWG\Parameter(
     *         name="category",
     *         in="query",
     *         type="string",
     *         required=true,
     *         description="newcar or aftersale"
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
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#definitions/OfferAftersaleComplete"))
     *                 )
     *             }
     *         )
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
        $category = $request->query->get('category');

        if (empty($category)) {
            throw new InvalidArgumentException('Empty category');
        }

        $type = self::OFFERTYPE[$category];

        $parnerIds = $request->query->get('partnerIds');

        if(!empty($parnerIds) && is_string($parnerIds)) {
            $parnerIds = explode(',', $parnerIds);
        }

        $em = $this->getDoctrine();
        $offers = $em->getRepository($type['repository'])->findOffersSinceAYear($parnerIds);

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
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="object",
     *                         allOf={
     *                             @SWG\Definition(ref="#definitions/OfferAftersaleComplete")
     *                         }
     *                     )
     *                 )
     *             }
     *         )
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

        $type  = self::OFFERTYPE[strtolower($subtype->getType()->getCategory())];

        $offer = new $type['entity']($subtype);

        $form = $this->createForm($type['formType'], $offer);

        $form->submit($offerData);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for offer");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        if (
            $type['name'] !== self::OFFERTYPE['aftersale']['name'] ||
            (
                $type['name'] === self::OFFERTYPE['aftersale']['name']
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
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="object",
     *                         allOf={
     *                             @SWG\Definition(ref="#definitions/OfferSaleComplete")
     *                         }
     *                     )
     *                 )
     *             }
     *         )
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

        $type = self::OFFERTYPE[strtolower($subtype->getType()->getCategory())];

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
}
