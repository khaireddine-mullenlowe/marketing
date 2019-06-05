<?php

namespace MarketingBundle\Controller;

use MarketingBundle\Entity\MyaudiUserInvitation;
use MarketingBundle\Enum\PaginateEnum;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Form\MyaudiUserInvitationFormType;
use MarketingBundle\Repository\MyaudiUserInvitationRepository;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Route;

/**
 * Class MyaudiUserInvitationController
 * @package MarketingBundle\Controller
 * @Route("invitation-user")
 */
class MyaudiUserInvitationController extends MullenloweRestController
{
    const CONTEXT = 'MyaudiUserInvitation';
    const LIMIT = 1000;

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/invitation-user",
     *     summary="Get InvitationsUser",
     *     operationId="getInvitationsUser",
     *     tags={"Invitation"},
     *     @SWG\Parameter(
     *         name="invitation",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Get myAudiUserInvitations by invitationId"
     *     ),
     *     @SWG\Parameter(
     *         name="myaudiUserId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Get myAudiUserInvitations by userId"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="InvitationsUser",
     *         @SWG\Definition(ref="#/definitions/MyaudiUserInvitationContextMulti")
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
        /** @var MyaudiUserInvitationRepository $repository */
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:MyaudiUserInvitation');
        $queryBuilder = $repository->findAll();
        // Get MyaudUserinvitations by criterias
        if (!empty($this->handleMyaduUserInvitationCriterias($request))) {
            $queryBuilder = $repository->findByCustomFilters($this->handleMyaduUserInvitationCriterias($request));
        }

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', self::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/")
     * @Rest\View()
     *
     * @SWG\Post(
     *     path="/invitation-user/",
     *     summary="Subscribe a user to an invitation",
     *     operationId="postMyaudiUserInvitation",
     *     tags={"Invitation"},
     *     @SWG\Parameter(
     *         name="myaudiUserInvitationPayload",
     *         in="body",
     *         required=true,
     *         description="",
     *         @SWG\Schema(ref="#/definitions/MyaudiUserInvitationPayload")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Subscription",
     *         @SWG\Definition(ref="#/definitions/MyaudiUserInvitation")
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
        $myaudiUserInvitation = new MyaudiUserInvitation();

        $form = $this->createForm(MyaudiUserInvitationFormType::class, $myaudiUserInvitation);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for MyaudiUserInvitation.");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($myaudiUserInvitation);
        $em->flush();

        return $this->createView($myaudiUserInvitation, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Delete("/{id}", requirements={"id"="\d+"})
     *
     * @SWG\Delete(
     *      path="/invitation-user/{id}",
     *      summary="Delete MyaudiUserInvitation by id",
     *      operationId="deleteMyaudiUserInvitationById",
     *     tags={"Invitation"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="MyaudiUserInvitation Id to delete"
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
        $myaudiUserInvitation = $em->getRepository('MarketingBundle:MyaudiUserInvitation')->find($id);

        if (!$myaudiUserInvitation) {
            throw new NotFoundHttpException(self::CONTEXT, 'MyaudiUserInvitation entity not found.');
        }

        $em->remove($myaudiUserInvitation);
        $em->flush();

        return $this->deleteView();
    }

    /**
     * @param Request $request
     * @return array
     */
    private function handleMyaduUserInvitationCriterias(Request $request)
    {
        $criterias = [];
        $invitation = $request->query->get('invitation');
        $myaudiUserId = $request->query->get('myaudiUserId');
        if (!empty($invitation) && !empty($myaudiUserId)) {
            $criterias = ['invitation' => $invitation, 'myaudiUserId' => $myaudiUserId];
        } elseif (!empty($invitation)) {
            $criterias = ['invitation' => $invitation];
        } elseif (!empty($myaudiUserId)) {
            $criterias = ['myaudiUserId' => $myaudiUserId];
        }

        return $criterias;
    }
}
