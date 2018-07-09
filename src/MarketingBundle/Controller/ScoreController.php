<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class ScoreController
 * @package MarketingBundle\Controller
 * @Route("score")
 */
class ScoreController extends MullenloweRestController
{
    const CONTEXT = 'Score';

    /**
     * @Rest\Get("/{myaudiUserId}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/score/{myaudiUserId}",
     *     summary="Get Score for a myaudiUser",
     *     operationId="getScore",
     *     tags={"Score"},
     *     @SWG\Parameter(
     *         name="myaudiUserId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="MyaudiUser ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A Score",
     *         @SWG\Definition(ref="#/definitions/ScoreContext")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param int $myaudiUserId
     * @return View
     */
    public function getAction(int $myaudiUserId)
    {
        $score = $this->getDoctrine()
            ->getRepository('MarketingBundle:Score')
            ->findBy(['myaudiUserId' => $myaudiUserId]);

        if (empty($score)) {
            throw $this->createNotFoundException('Score not found');
        }

        return $this->createView($score);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/score",
     *     summary="Get Scores",
     *     operationId="getScores",
     *     tags={"Score"},
     *     @SWG\Response(
     *         response="200",
     *         description="Scores",
     *         @SWG\Definition(ref="#/definitions/ScoreContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:Score');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('score'),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}
