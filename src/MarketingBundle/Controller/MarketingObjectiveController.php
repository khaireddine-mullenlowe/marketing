<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

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
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}
