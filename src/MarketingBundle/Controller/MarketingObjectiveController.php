<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Enum\PaginateEnum;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * Class MarketingObjectiveController
 * @package MarketingBundle\Controller
 * @Route("marketing-objective")
 */
class MarketingObjectiveController extends MullenloweRestController
{
    const CONTEXT = 'MarketingObjective';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/marketing-objective/{id}",
     *     summary="Get Marketing Objective",
     *     operationId="getMarketingObjective",
     *     tags={"MarketingObjective"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="MarketingObjective ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A MarketingObjective",
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
        $marketingObjective = $this->getDoctrine()
            ->getRepository('MarketingBundle:MarketingObjective')
            ->find($id);

        if (empty($marketingObjective)) {
            throw $this->createNotFoundException('MarketingObjective not found');
        }

        return $this->createView($marketingObjective);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/marketing-objective",
     *     summary="Get MarketingObjectives",
     *     operationId="getMarketingObjectives",
     *     tags={"MarketingObjective"},
     *     @SWG\Response(
     *         response="200",
     *         description="MarketingObjectives",
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:MarketingObjective');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('marketingObjective'),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
