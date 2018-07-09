<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class SubscriptionController
 * @package MarketingBundle\Controller
 * @Route("subscription")
 */
class SubscriptionController extends MullenloweRestController
{
    const CONTEXT = 'Subscription';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/subscription/{id}",
     *     summary="Get Subscription",
     *     operationId="getSubscription",
     *     tags={"Subscription"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Subscription ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A Subscription",
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
        $subscription = $this->getDoctrine()
            ->getRepository('MarketingBundle:Subscription')
            ->find($id);

        if (empty($subscription)) {
            throw $this->createNotFoundException('Subscription not found');
        }

        return $this->createView($subscription);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/subscription",
     *     summary="Get Subscriptions",
     *     operationId="getSubscriptions",
     *     tags={"Subscription"},
     *     @SWG\Response(
     *         response="200",
     *         description="Subscriptions",
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:Subscription');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('subscription'),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}
