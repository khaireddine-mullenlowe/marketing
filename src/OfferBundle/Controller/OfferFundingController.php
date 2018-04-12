<?php

namespace OfferBundle\Controller;

use Knp\Component\Pager\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use OfferBundle\Entity\OfferFunding;
use OfferBundle\Form\OfferFundingType;
use OfferBundle\Repository\Elastica\OfferFundingRepository;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;

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
     * @return \FOS\RestBundle\View\View
     *
     * @SWG\Post(
     *     path="/offer/funding",
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
     *         response="201",
     *         description="OfferFunding created",
     *         @SWG\Schema(ref="#/definitions/OfferFundingComplete")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Bad request",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function postAction(Request $request)
    {
        if ($request->request->count() === 0 || !$request->request->has('funding')) {
            throw new BadRequestHttpException(self::CONTEXT, 'Input data are empty.');
        }

        $data = $request->request->get('funding');
        $funding = new OfferFunding();

        return $this->editOfferFunding($data, $funding);
    }

    /**
     * @Rest\Patch("/funding/{id}")
     * @param Request $request
     * @param integer $id
     * @return \FOS\RestBundle\View\View
     *
     * @SWG\Patch(
     *     path="/offer/funding/{id}",
     *     summary="Edit a funding offer.",
     *     operationId="editOfferFunding",
     *     tags={"Offer Funding"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="OfferFunding Id to update"
     *     ),
     *     @SWG\Parameter(
     *         name="offerFunding",
     *         in="body",
     *         required=true,
     *         description="OfferFunding offer example",
     *         @SWG\Schema(ref="#/definitions/OfferFunding")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="OfferFunding edited",
     *         @SWG\Schema(ref="#/definitions/OfferFunding")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Bad request",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function patchAction(Request $request, int $id)
    {
        if ($request->request->count() === 0 || !$request->request->has('funding')) {
            throw new BadRequestHttpException(self::CONTEXT, 'Input data are empty.');
        }

        $funding = $this->getDoctrine()->getRepository('OfferBundle:OfferFunding')->find($id);
        if (!$funding instanceof OfferFunding) {
            throw new NotFoundHttpException(static::CONTEXT, sprintf('OfferFunding {%s} not found', $id));
        }

        $data = $request->request->get('funding');

        return $this->editOfferFunding($data, $funding, false);
    }

    /**
     * @Rest\Get("/funding")
     * @param Request $request
     * @return array
     *
     * @SWG\Get(
     *     path="/offer/funding",
     *     summary="Get a funding offers.",
     *     operationId="getOfferFundings",
     *     tags={"Offer Funding"},
     *     @SWG\Response(
     *         response="200",
     *         description="OfferFundings returned",
     *         @SWG\Schema(ref="#/definitions/OfferFundingComplete")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function cgetAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('OfferBundle:OfferFunding');

        $paginator = $this->get('knp_paginator');

        $queryBuilder = $repository->createQueryBuilder('funding');

        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return [
            'pagination' => [
                'total' => $pager->getTotalItemCount(),
                'count' => $pager->count(),
                'per_page' => $pager->getItemNumberPerPage(),
                'current_page' => $pager->getCurrentPageNumber(),
                'total_pages' => $pager->getPageCount(),
            ],
            'data' => $pager->getItems(),
        ];
    }

    /**
     * @Rest\Get("/funding/search")
     * @param Request $request
     * @return array
     *
     * @SWG\Get(
     *     path="/offer/funding/search",
     *     summary="Get a funding offers by label.",
     *     operationId="searchOfferFunding",
     *     tags={"Offer Funding"},
     *     @SWG\Parameter(
     *         name="q",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="OfferFunding label to search"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="OfferFundings returned",
     *         @SWG\Schema(ref="#/definitions/OfferFundingComplete")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Bad request",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function searchAction(Request $request)
    {
        if (!$request->query->get('q')) {
            throw new BadRequestHttpException(self::CONTEXT, 'Input data are empty.');
        }

        $label = $request->query->get('q');
        /** @var OfferFundingRepository $repository */
        $repository = $this->get('fos_elastica.manager')->getRepository('OfferBundle:OfferFunding');

        $paginator = $this->get('knp_paginator');
        $results = $repository->findByLabel($label);
        $pager = $paginator->paginate($results, $request->query->getInt('page', 1), $request->query->getInt('limit', 1));

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Get("/funding/{id}")
     * @param Request $request
     * @param integer $id
     * @return \FOS\RestBundle\View\View
     *
     * @SWG\Get(
     *     path="/offer/funding/{id}",
     *     summary="Get a funding offer.",
     *     operationId="getOfferFunding",
     *     tags={"Offer Funding"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="OfferFunding Id to get"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="OfferFunding returned",
     *         @SWG\Schema(ref="#/definitions/OfferFundingComplete")
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function getAction(Request $request, int $id)
    {
        $offerFunding = $this->getDoctrine()->getRepository('OfferBundle:OfferFunding')->find($id);
        if (!$offerFunding instanceof OfferFunding) {
            throw new NotFoundHttpException(static::CONTEXT, sprintf('OfferFunding {%s} not found', $id));
        }

        return $this->createView($offerFunding);
    }

    /**
     * Manage OfferFunding
     * @param array $data Sent data
     * @param OfferFunding $offerFunding OfferFunding object.
     * @param bool $clearMissing False in case of patch action.
     * @return \FOS\RestBundle\View\View
     */
    private function editOfferFunding(array $data, OfferFunding $offerFunding, $clearMissing = true)
    {

        $form = $this->createForm(OfferFundingType::class, $offerFunding);
        $form->submit($data, $clearMissing);
        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid.");
        }

        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->clear();
        $em->persist($offerFunding);
        $em->flush();

        return $this->createView($offerFunding, $clearMissing ? Response::HTTP_CREATED : Response::HTTP_OK);
    }
}
