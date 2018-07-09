<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class CallCenterController
 * @package MarketingBundle\Controller
 * @Route("call-center")
 */
class CallCenterController extends MullenloweRestController
{
    const CONTEXT = 'CallCenter';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/call-center/{id}",
     *     summary="Get Call Center",
     *     operationId="getCallCenter",
     *     tags={"CallCenter"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Call Center ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A CallCenter",
     *         @SWG\Definition(ref="#/definitions/BasicEntityContext")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param int $id
     * @return View
     */
    public function getAction(int $id)
    {
        $callCenter = $this->getDoctrine()
            ->getRepository('MarketingBundle:CallCenter')
            ->find($id);

        if (empty($callCenter)) {
            throw $this->createNotFoundException('CallCenter not found');
        }

        return $this->createView($callCenter);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/call-center",
     *     summary="Get Call Centers",
     *     operationId="getCallCenters",
     *     tags={"CallCenter"},
     *     @SWG\Response(
     *         response="200",
     *         description="CallCenters",
     *         @SWG\Definition(ref="#/definitions/BasicEntityContextMulti")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param Request $request
     * @return View
     */
    public function cgetAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:CallCenter');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('callCenter'),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}
