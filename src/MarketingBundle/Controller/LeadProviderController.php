<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Enum\PaginateEnum;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class LeadProviderController
 * @package MarketingBundle\Controller
 * @Route("lead-provider")
 */
class LeadProviderController extends MullenloweRestController
{
    const CONTEXT = 'LeadProvider';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     *  @SWG\Get(
     *     path="/lead-provider/{id}",
     *     summary="Get Lead Provider",
     *     operationId="getLeadProvider",
     *     tags={"LeadProvider"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Lead Provider ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A LeadProvider",
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
        $leadProvider = $this->getDoctrine()
            ->getRepository('MarketingBundle:LeadProvider')
            ->find($id);

        if (empty($leadProvider)) {
            throw $this->createNotFoundException('LeadProvider not found');
        }

        return $this->createView($leadProvider);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/lead-provider",
     *     summary="Get Lead Providers",
     *     operationId="getLeadProviders",
     *     tags={"LeadProvider"},
     *     @SWG\Response(
     *         response="200",
     *         description="LeadProviders",
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:LeadProvider');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('leadProvider'),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
