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
    const CONTEXT = 'score';

    /**
     * @Rest\Get("/{myaudiUserId}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @param int $myaudiUserId
     * @return View
     */
    public function getAction(int $myaudiUserId)
    {
        $score = $this->getDoctrine()
            ->getRepository('MarketingBundle:Score')
            ->findBy(['myaudiUserId' => $myaudiUserId]);

        return $this->createView($score);
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
