<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Entity\MyaudiUserMarketingObjective;
use MarketingBundle\Enum\PaginateEnum;
use MarketingBundle\Form\MyaudiUserMarketingObjectiveType;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * Class MyaudiUserMarketingObjectiveController
 * @package MarketingBundle\Controller
 * @Route("myaudi-user-marketing-objective")
 */
class MyaudiUserMarketingObjectiveController extends MullenloweRestController
{
    const CONTEXT = 'MyaudiUserMarketingObjective';

    /**
     * @Rest\Get("/{userId}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/myaudi-user-marketing-objective/{userId}",
     *     summary="Get Marketing Objective for a User",
     *     operationId="getMarketingObjectiveUser",
     *     tags={"MarketingObjective"},
     *     @SWG\Parameter(
     *         name="userId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="UserId ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="MarketingObjectives for a User",
     *         @SWG\Definition(ref="#/definitions/MyaudiUserMarketingObjectiveContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:MyaudiUserMarketingObjective');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->findBy(['myaudiUserId' => $userId]),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/")
     * @Rest\View()
     *
     * @SWG\Post(
     *     path="/myaudi-user-marketing-objective/",
     *     summary="Subscribe a user to a Marketing Objective",
     *     operationId="postMarketingObjectiveUser",
     *     tags={"MarketingObjective"},
     *     @SWG\Parameter(
     *         name="myaudiUserMarketingObjective",
     *         in="body",
     *         type="integer",
     *         required=true,
     *         description="",
     *         @SWG\Schema(ref="#/definitions/MyaudiUserMarketingObjective")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Subscription",
     *         @SWG\Definition(ref="#/definitions/MyaudiUserMarketingObjectiveContext")
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
    public function postAction(Request $request)
    {
        $data = $request->request->all();

        $myaudiUserMarketingObjective = new MyaudiUserMarketingObjective();

        $form = $this->createForm(MyaudiUserMarketingObjectiveType::class, $myaudiUserMarketingObjective);

        $form->submit($data);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for offer");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($myaudiUserMarketingObjective);
        $em->flush();

        return $this->createView($myaudiUserMarketingObjective);
    }

    /**
     * @Rest\Put("/")
     * @Rest\View()
     *
     * @SWG\Put(
     *     path="/myaudi-user-marketing-objective/",
     *     summary="Update subscription for user to a Marketing Objective",
     *     operationId="putMarketingObjectiveUser",
     *     tags={"MarketingObjective"},
     *     @SWG\Parameter(
     *         name="myaudiUserMarketingObjective",
     *         in="body",
     *         type="integer",
     *         required=true,
     *         description="",
     *         @SWG\Schema(ref="#/definitions/MyaudiUserMarketingObjective")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Subscription",
     *         @SWG\Definition(ref="#/definitions/MyaudiUserMarketingObjectiveContext")
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
    public function putAction(Request $request)
    {
        $data = $request->request->all();

        $myaudiUserMarketingObjective = $this->getDoctrine()->getRepository('MarketingBundle:MyaudiUserMarketingObjective')
                ->findOneBy(['myaudiUserId' => $data['myaudiUserId'], 'marketingObjective' => $data['marketingObjective']]);

        $form = $this->createForm(MyaudiUserMarketingObjectiveType::class, $myaudiUserMarketingObjective);

        $form->submit($data);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for offer");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($myaudiUserMarketingObjective);
        $em->flush();

        return  $this->createView($myaudiUserMarketingObjective);
    }
}
