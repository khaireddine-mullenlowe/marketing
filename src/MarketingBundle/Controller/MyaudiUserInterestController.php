<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Entity\MyaudiUserInterest;
use MarketingBundle\Enum\PaginateEnum;
use MarketingBundle\Form\MyaudiUserInterestType;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MyaudiUserInterestController
 * @package MarketingBundle\Controller
 * @Route("interest-user")
 */
class MyaudiUserInterestController extends MullenloweRestController
{
    const CONTEXT = 'MyaudiUserInterest';

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
     *         @SWG\Definition(ref="#/definitions/MyaudiUserInterestContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:MyaudiUserInterest');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->findBy(['userId' => $userId]),
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
     *     path="/interest-user/",
     *     summary="Subscribe a user to an Interest",
     *     operationId="postMyaudiUserInterest",
     *     tags={"Interest"},
     *     @SWG\Parameter(
     *         name="myaudiUserInterestPayload",
     *         in="body",
     *         required=true,
     *         description="",
     *         @SWG\Schema(ref="#/definitions/MyaudiUserInterestPayload")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Subscription",
     *         @SWG\Definition(ref="#/definitions/MyaudiUserInterest")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="internal error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $myaudiUserInterest = new MyaudiUserInterest();

        $form = $this->createForm(MyaudiUserInterestType::class, $myaudiUserInterest);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for MyaudiUserInterest.");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($myaudiUserInterest);
        $em->flush();

        return $this->createView($myaudiUserInterest, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/{id}", requirements={"id"="\d+"})
     *
     * @SWG\Delete(
     *      path="/interest-user/{id}",
     *      summary="Delete MyaudiUserInterest by id",
     *      operationId="deleteMyaudiUserInterestById",
     *     tags={"Interest"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="MyaudiUserInterest Id to delete"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="delete status",
     *         @SWG\Schema(ref="#/definitions/Success")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="internal error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @Rest\View()
     *
     * @param int $id
     * @return View
     */
    public function deleteAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $myaudiUserInterest = $em->getRepository('MarketingBundle:MyaudiUserInterest')->find($id);

        if (!$myaudiUserInterest) {
            throw new NotFoundHttpException(self::CONTEXT, 'MyaudiUserInterest entity not found.');
        }

        $em->remove($myaudiUserInterest);
        $em->flush();

        return $this->deleteView();
    }
}
