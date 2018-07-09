<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use MarketingBundle\Enum\PaginateEnum;
use Swagger\Annotations as SWG;

/**
 * Class EventTypeController
 * @package MarketingBundle\Controller
 * @Route("event-type")
 */
class EventTypeController extends MullenloweRestController
{
    const CONTEXT = 'EventType';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/event-type/{id}",
     *     summary="Get EventType",
     *     operationId="getEventType",
     *     tags={"EventType"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="EventType ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="An EventType",
     *         @SWG\Definition(ref="#/definitions/EventTypeContext")
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
        $eventType = $this->getDoctrine()
            ->getRepository('MarketingBundle:EventType')
            ->find($id);

        if (empty($eventType)) {
            throw $this->createNotFoundException('EventType not found');
        }

        return $this->createView($eventType);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/event-type",
     *     summary="Get EventTypes",
     *     operationId="getEventTypes",
     *     tags={"EventType"},
     *     @SWG\Response(
     *         response="200",
     *         description="EventTypes",
     *         @SWG\Definition(ref="#/definitions/EventTypeContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:EventType');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('eventType'),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
