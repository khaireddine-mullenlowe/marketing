<?php

namespace MarketingBundle\Controller;

use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Entity\MyaudiUserMarketingObjective;
use MarketingBundle\Enum\PaginateEnum;
use MarketingBundle\Form\MyaudiUserMarketingObjectiveType;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MyaudiUserMarketingObjectiveController
 * @package MarketingBundle\Controller
 * @Route("myaudi-user-marketing-objective")
 */
class MyaudiUserMarketingObjectiveController extends MullenloweRestController
{
    const CONTEXT = 'MyaudiUserMarketingObjective';

    /**
     * @Rest\Get(
     *     "/{myaudiUserId}",
     *     name="get_myaudiUser_marketingObjective",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/myaudi-user-marketing-objective/{myaudiUserId}",
     *     summary="Get Marketing Objective for a User",
     *     operationId="getMarketingObjectiveUser",
     *     tags={"MarketingObjective"},
     *     @SWG\Parameter(
     *         name="myaudiUserId",
     *         in="path",
     *         type="integer",
     *         required=false,
     *         description="myaudiUser ID"
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
     * @param int     $myaudiUserId
     * @return View
     */
    public function cgetAction(Request $request, int $myaudiUserId)
    {
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:MyaudiUserMarketingObjective');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->findBy(['myaudiUserId' => $myaudiUserId]),
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
     *         required=true,
     *         description="",
     *         @SWG\Schema(ref="#/definitions/MyaudiUserMarketingObjectiveBasic")
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
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postAction(Request $request)
    {
        $data = $request->request->all();
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $myaudiUserMarketingObjective = new MyaudiUserMarketingObjective();

        $form = $this->createForm(MyaudiUserMarketingObjectiveType::class, $myaudiUserMarketingObjective);

        $form->submit($data);
        if (!($form->isSubmitted() && $form->isValid())) {

            return $this->view($form);
        }

        $currentMyaudiUserMarketingObjective = $em->getRepository('MarketingBundle:MyaudiUserMarketingObjective')
            ->findOneBy([
                'myaudiUserId' => $data['myaudiUserId'],
                'marketingObjective' => $data['marketingObjective']
            ]);

        if ($currentMyaudiUserMarketingObjective instanceof MyaudiUserMarketingObjective) {
            $inputData = $request->request->all();

            return $this->putOrPatch($inputData, $currentMyaudiUserMarketingObjective->getId(), false);
        }

        $em->persist($myaudiUserMarketingObjective);
        $em->flush();

        return $this->createView($myaudiUserMarketingObjective, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put("/{id}")
     * @Rest\View()
     *
     * @SWG\Put(
     *     path="/myaudi-user-marketing-objective/{id}",
     *     summary="Update subscription for user to a Marketing Objective",
     *     operationId="putMarketingObjectiveUser",
     *     tags={"MarketingObjective"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="MyaudiUserMarketingObjective ID to update"
     *     ),
     *     @SWG\Parameter(
     *         name="myaudiUserMarketingObjective",
     *         in="body",
     *         type="integer",
     *         required=true,
     *         description="",
     *         @SWG\Schema(ref="#/definitions/MyaudiUserMarketingObjectiveBasic")
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
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="updating error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param Request $request
     * @return View
     */
    public function putAction(Request $request, int $id)
    {
        return $this->putOrPatch($request->request->all(), $id);

        $data = $request->request->all();

        $myaudiUserMarketingObjective =
            $this->getDoctrine()->getRepository('MarketingBundle:MyaudiUserMarketingObjective')
                ->findOneBy(
                    ['myaudiUserId' => $data['myaudiUserId'], 'marketingObjective' => $data['marketingObjective']]
                );

        if (empty($myaudiUserMarketingObjective)) {
            throw new \InvalidArgumentException('myaudiUserMarketingObjective Not Found');
        }

        $form = $this->createForm(MyaudiUserMarketingObjectiveType::class, $myaudiUserMarketingObjective);

        $form->submit($data);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(
                static::CONTEXT,
                "Form fields are not valid for myaudiUserMarketingObjective"
            );
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($myaudiUserMarketingObjective);
        $em->flush();

        return  $this->createView($myaudiUserMarketingObjective);
    }

    /**
     * @Rest\Patch("/{id}")
     * @Rest\View()
     *
     * @SWG\Patch(
     *     path="/myaudi-user-marketing-objective/{id}",
     *     summary="Patch subscription for user to a Marketing Objective",
     *     operationId="patchMarketingObjectiveUser",
     *     tags={"MarketingObjective"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="MyaudiUserMarketingObjective ID to patch"
     *     ),
     *     @SWG\Parameter(
     *         name="myaudiUserMarketingObjective",
     *         in="body",
     *         type="integer",
     *         required=true,
     *         description="",
     *         @SWG\Schema(ref="#/definitions/MyaudiUserMarketingObjectiveBasic")
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
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="updating error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param Request   $request
     * @param int       $id
     * @return View
     */
    public function patchAction(Request $request, int $id)
    {
        $inputData = $request->request->all();
        if (true == $request->query->get('merge')) {
            $this->cleanData($inputData);
        }

        return $this->putOrPatch($inputData, $id, false);
    }

    /**
     * Handles put or patch action
     *
     * @param array $inputData
     * @param int $id myaudiUserMarketingObjective ID
     * @param bool $clearMissing
     *
     * @return \FOS\RestBundle\View\View
     */
    private function putOrPatch($inputData, int $id, $clearMissing = true)
    {
        $em = $this->getDoctrine()->getManager();

        $myaudiUserMarketingObjective = $em
            ->getRepository('MarketingBundle:MyaudiUserMarketingObjective')
            ->find($id);

        if (!$myaudiUserMarketingObjective) {
            throw new NotFoundHttpException(self::CONTEXT, 'MyaudiUserMarketingObjective not found');
        }

        $form = $this->createForm(MyaudiUserMarketingObjectiveType::class, $myaudiUserMarketingObjective);
        $form->submit($inputData, $clearMissing);
        //validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($myaudiUserMarketingObjective);
        $em->flush();

        return $this->createView($myaudiUserMarketingObjective);
    }
}
