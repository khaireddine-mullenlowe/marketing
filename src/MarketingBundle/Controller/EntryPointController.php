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
 * Class EntryPointController
 * @package MarketingBundle\Controller
 * @Route("entry-point")
 */
class EntryPointController extends MullenloweRestController
{
    const CONTEXT = 'EntryPoint';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/entry-point/{id}",
     *     summary="Get Entry Point",
     *     operationId="getEntryPoint",
     *     tags={"EntryPoint"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Entry Point ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="An Entry Point",
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
        $entryPoint = $this->getDoctrine()
            ->getRepository('MarketingBundle:EntryPoint')
            ->find($id);

        if (empty($entryPoint)) {
            throw $this->createNotFoundException('EntryPoint not found');
        }

        return $this->createView($entryPoint);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/entry-point",
     *     summary="Get EntryPoints",
     *     operationId="getEntryPoints",
     *     tags={"EntryPoint"},
     *     @SWG\Response(
     *         response="200",
     *         description="Entry Points",
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:EntryPoint');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('entryPoint'),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
