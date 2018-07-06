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
