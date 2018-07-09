<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class EntryPointUserController
 * @package MarketingBundle\Controller
 * @Route("entry-point-user")
 */
class EntryPointUserController extends MullenloweRestController
{
    const CONTEXT = 'EntryPointUser';

    /**
     * @Rest\Get("/{userId}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/entry-point-user/{userId}",
     *     summary="Get EntryPoint for a user",
     *     operationId="getEntryPoint",
     *     tags={"EntryPoint"},
     *     @SWG\Parameter(
     *         name="userId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="User ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="EntryPoint for a User",
     *         @SWG\Definition(ref="#/definitions/EntryPointUserContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:EntryPointUser');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->findBy(['userId' => $userId]),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}
