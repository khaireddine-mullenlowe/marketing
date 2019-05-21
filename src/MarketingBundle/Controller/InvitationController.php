<?php


namespace MarketingBundle\Controller;

use Doctrine\ORM\OptimisticLockException;
use FOS\RestBundle\View\View;
use MarketingBundle\Entity\CampaignEvent;
use MarketingBundle\Entity\Invitation;
use MarketingBundle\Enum\PaginateEnum;
use MarketingBundle\Form\InvitationFormType;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Route;

/**
 * Class InvitationController
 * @package MarketingBundle\Controller
 * @Route("invitation")
 */
class InvitationController extends MullenloweRestController
{
    const CONTEXT = 'Invitation';
    const LIMIT = 1000;

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/invitation/{id}",
     *     summary="Get invitation",
     *     operationId="getInvitation",
     *     tags={"Invitation"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Invitation ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="An Invitation",
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
        $invitation = $this->getDoctrine()
            ->getRepository('MarketingBundle:Invitation')
            ->find($id);

        if (empty($invitation)) {
            throw new NotFoundHttpException(self::CONTEXT, 'Invitation not found');
        }

        return $this->createView($invitation);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/invitation",
     *     summary="Get Invitations",
     *     operationId="getInvitations",
     *     tags={"Invitation"},
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="Get invitations where name"
     *     ),
     *     @SWG\Parameter(
     *         name="status",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Get invitations where status"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Invitations",
     *         @SWG\Schema(type="array", @SWG\Items(ref="#/definitions/Invitation"))
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:Invitation');
        $queryBuilder = $repository->findAll();
        //Get invitations by criterias
        if (!empty($this->handleInvitationCriterias($request))) {
            $queryBuilder = $repository->findBy(
                $this->handleInvitationCriterias($request)
            );

            return $this->createView($queryBuilder);
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
     *     path="/invitation/",
     *     summary="create invitation",
     *     operationId="createInvitation",
     *     tags={"Invitation"},
     *     @SWG\Parameter(
     *         name="invitation",
     *         in="body",
     *         required=true,
     *         description="Invitation payload",
     *         @SWG\Schema(ref="#/definitions/Invitation")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created invitation",
     *         @SWG\Schema(ref="#/definitions/InvitationComplete")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Invitation page not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Internal server error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();
        $invitation = new Invitation();

        $form = $this->createForm(InvitationFormType::class, $invitation);
        $form->submit($dataInput);
        // validate
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($invitation);
        $em->flush();

        return $this->createView($invitation, Response::HTTP_CREATED);
    }

    /**
     * @Rest\Put(
     *     "/{id}",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View()
     *
     * @SWG\Put(
     *     summary="update invitation from id",
     *     operationId="putInvitationById",
     *     security={{ "bearer":{} }},
     *     path="/invitation/{id}",
     *     tags={"Invitation"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="invitationId"
     *     ),
     *     @SWG\Parameter(
     *         name="Invitation",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Invitation")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated invitation",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/InvitationComplete"),
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Invitation page not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Internal server error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *    security={{ "bearer":{} }}
     * )
     *
     * @param Request $request
     * @param $id
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        return $this->putOrPatch($request, $id);
    }

    /**
     * @Rest\Patch(
     *     "/{id}",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View()
     *
     * @SWG\Patch(
     *     path="/invitation/{id}",
     *     summary="patch invitation from id",
     *     operationId="patchInvitationById",
     *     security={{ "bearer":{} }},
     *     tags={"Invitation"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="invitationId"
     *     ),
     *     @SWG\Parameter(
     *         name="invitation",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/Invitation")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated invitation",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/InvitationComplete"),
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="Invitation page not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="Internal server error",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     ),
     * )
     *
     * @param Request $request
     * @param int $id
     * @return View
     * @throws OptimisticLockException
     */
    public function patchAction(Request $request, $id)
    {
        return $this->putOrPatch($request, $id, false);
    }

    /**
     * @Rest\Delete(
     *     "/{id}",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View()
     *
     * @SWG\Delete(
     *     path="/invitation/{id}",
     *     summary="remove invitation from id",
     *     operationId="removeInvitationById",
     *     tags={"Invitation"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="invitationId"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the invitation"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema()
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="internal error",
     *         @SWG\Schema()
     *    ),
     *    security={{ "bearer":{} }}
     * )
     *
     * @param int $id
     * @return View
     */
    public function deleteAction(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $invitation = $em->getRepository('MarketingBundle:Invitation')->find($id);
        if (!$invitation) {
            throw new NotFoundHttpException(self::CONTEXT, sprintf('Invitation #%d not found', $id));
        }

        $em->remove($invitation);
        $em->flush();

        return $this->deleteView();
    }

    /**
     * @param Request $request
     * @param int $id
     * @param bool $clearMissing
     * @return View
     */
    private function putOrPatch(Request $request, int $id, $clearMissing = true)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $invitation = $em->getRepository(Invitation::class)->find($id);
        if (!$invitation) {
            throw new NotFoundHttpException(self::CONTEXT, sprintf('Invitation #%d not found', $id));
        }

        $form = $this->createForm(InvitationFormType::class, $invitation);
        $form->submit($dataInput, $clearMissing);
        if (!$form->isValid()) {
            return $this->view($form);
        }

        $em->merge($invitation);
        $em->flush();

        return $this->createView($invitation);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function handleInvitationCriterias(Request $request)
    {
        $criterias = [];
        $invitationStatus = $request->query->getInt('status');
        $invitationName = $request->query->get('name');
        if (!empty($invitationName) && is_string($invitationName)) {
            $criterias = ['name' => $invitationName];
        }

        if (isset($invitationStatus) && in_array($invitationStatus, [1, -1])) {
            $criterias = ['status' => (int)$invitationStatus];
        }

        return $criterias;
    }
}
