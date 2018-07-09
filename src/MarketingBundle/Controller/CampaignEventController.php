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
 * Class CampaignEventController
 * @package MarketingBundle\Controller
 * @Route("campaign-event")
 */
class CampaignEventController extends MullenloweRestController
{
    const CONTEXT = 'CampaignEvent';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/campaign-event/{id}",
     *     summary="Get CampaignEvent",
     *     operationId="getCampaignEvent",
     *     tags={"CampaignEvent"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="CampaignEvent ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A CampaignEvent",
     *         @SWG\Definition(ref="#/definitions/CampaignEventContext")
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
        $event = $this->getDoctrine()
            ->getRepository('MarketingBundle:CampaignEventContext')
            ->find($id);

        if (empty($event)) {
            throw $this->createNotFoundException('Event not found');
        }

        return $this->createView($event);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/campaign-event",
     *     summary="Get CampaignEvents",
     *     operationId="getCampaignEvents",
     *     tags={"CampaignEvent"},
     *     @SWG\Response(
     *         response="200",
     *         description="CampaignEvents",
     *         @SWG\Definition(ref="#/definitions/CampaignEventContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:CampaignEvent');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('campaignEvent'),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
