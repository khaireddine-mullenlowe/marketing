<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class MyaudiUserMarketingObjectiveController
 * @package MarketingBundle\Controller
 * @Route("myaudi-user-marketing-objective")
 */
class MyaudiUserMarketingObjectiveController extends MullenloweRestController
{
    const CONTEXT = 'MyaudiUserMarketingObjective';

    /**
     * @Rest\Get("/{userId}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/myaudi-user-marketing-objective/{userId}",
     *     summary="Get Marketing Objective for a User",
     *     operationId="getMarketingObjectiveUser",
     *     tags={"MarketingObjective"},
     *     @SWG\Parameter(
     *         name="userId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="UserId ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="MarketingObjectives for a User",
     *         @SWG\Definition(ref="#/definitions/MyaudiUserMarketingObjectiveContextMulti")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param Request $request
     * @param int     $userId
     * @return View
     */
    public function cgetAction(Request $request, int $userId)
    {
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:MyaudiUserMarketingObjective');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->findBy(['myaudiUserId' => $userId]),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}
