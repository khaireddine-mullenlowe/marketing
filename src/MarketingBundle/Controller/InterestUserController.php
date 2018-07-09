<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class InterestUserController
 * @package MarketingBundle\Controller
 * @Route("interest-user")
 */
class InterestUserController extends MullenloweRestController
{
    const CONTEXT = 'InterestUser';

    /**
     * @Rest\Get("/{userId}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/interest-user",
     *     summary="Get Interests for a user",
     *     operationId="getInterestsUser",
     *     tags={"Interest"},
     *     @SWG\Response(
     *         response="200",
     *         description="Interests for a user",
     *         @SWG\Definition(ref="#/definitions/InterestUserContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:InterestUser');

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
