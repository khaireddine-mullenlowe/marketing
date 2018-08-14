<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Entity\InterestUser;
use MarketingBundle\Enum\PaginateEnum;
use MarketingBundle\Form\InterestUserType;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;

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
     *     operationId="postInterestUser",
     *     tags={"Interest"},
     *     @SWG\Parameter(
     *         name="interestUserPayload",
     *         in="body",
     *         required=true,
     *         description="",
     *         @SWG\Schema(ref="#/definitions/InterestUserPayload")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Subscription",
     *         @SWG\Definition(ref="#/definitions/InterestUser")
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
        $interestUser = new InterestUser();

        $form = $this->createForm(InterestUserType::class, $interestUser);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for interestUser.");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($interestUser);
        $em->flush();

        return $this->createView($interestUser, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/{id}", requirements={"id"="\d+"})
     *
     * @SWG\Delete(
     *      path="/interest-user/{id}",
     *      summary="Delete InterestUser by id",
     *      operationId="deleteInterestUserById",
     *     tags={"Interest"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="InterestUser Id to delete"
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
        $interestUser = $em->getRepository('MarketingBundle:InterestUser')->find($id);

        if (!$interestUser) {
            throw new NotFoundHttpException(self::CONTEXT, 'InterestUser entity not found.');
        }

        $em->remove($interestUser);
        $em->flush();

        return $this->deleteView();
    }
}
