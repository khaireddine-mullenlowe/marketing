<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class LeadTypeController
 * @package MarketingBundle\Controller
 * @Route("lead-type")
 */
class LeadTypeController extends MullenloweRestController
{
    const CONTEXT = 'LeadType';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @param int $id
     * @return View
     */
    public function getAction(int $id)
    {
        $leadType = $this->getDoctrine()
            ->getRepository('MarketingBundle:LeadType')
            ->find($id);

        if (empty($leadType)) {
            throw $this->createNotFoundException('LeadType not found');
        }

        return $this->createView($leadType);
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:LeadType');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('leadType'),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}
