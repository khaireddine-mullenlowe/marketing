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
 * Class InterestController
 * @package MarketingBundle\Controller
 * @Route("interest")
 */
class InterestController extends MullenloweRestController
{
    const CONTEXT = 'Interest';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/interest/{id}",
     *     summary="Get Interest",
     *     operationId="getInterest",
     *     tags={"Interest"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Interest ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="An Interest",
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
        $interest = $this->getDoctrine()
            ->getRepository('MarketingBundle:Interest')
            ->find($id);

        if (empty($interest)) {
            throw $this->createNotFoundException('Interest not found');
        }

        return $this->createView($interest);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/interest",
     *     summary="Get Interests",
     *     operationId="getInterests",
     *     tags={"Interest"},
     *     @SWG\Response(
     *         response="200",
     *         description="Interests",
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:Interest');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('interest'),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
