<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Entity\CampaignEvent;
use MarketingBundle\Form\CampaignEventType;
use MarketingBundle\Repository\CampaignEventRepository;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use MarketingBundle\Enum\PaginateEnum;
use Swagger\Annotations as SWG;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CampaignEventController
 * @package MarketingBundle\Controller
 * @Route("campaign-event")
 */
class CampaignEventController extends MullenloweRestController
{
    const CONTEXT = 'CampaignEvent';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/campaign-event/{id}",
     *     summary="Get CampaignEvent",
     *     operationId="getCampaignEvent",
     *     tags={"CampaignEvent"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="CampaignEvent ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A CampaignEvent",
     *         @SWG\Definition(ref="#/definitions/CampaignEventContext")
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
        $campaignEvent = $this->getDoctrine()
            ->getRepository('MarketingBundle:CampaignEvent')
            ->find($id);

        if (empty($campaignEvent)) {
            throw $this->createNotFoundException('Compain Event not found');
        }

        return $this->createView($campaignEvent);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/campaign-event",
     *     summary="Get CampaignEvents collection",
     *     operationId="getCampaignEventsCollection",
     *     tags={"CampaignEvent"},
     *     @SWG\Parameter(
     *         name="limit",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="limit"
     *     ),
     *     @SWG\Parameter(
     *         name="eventType",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Find campaign events by eventType"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="CampaignEvents",
     *         @SWG\Definition(ref="#/definitions/CampaignEventContextMulti")
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
        /** @var CampaignEventRepository $repository */
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:CampaignEvent');
        $criterias = $request->query->all();

        if (!empty($criterias['limit']) && (int) $criterias['limit'] === -1) {
            $queryBuilder = $repository->findByCustomFilters($criterias, $criterias);

            return $this->createView($queryBuilder->getResult());
        }

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->findByCustomFilters($criterias, $criterias),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * Creates a new Campaign Event entity.
     *
     * @Rest\Post("/", name="_post_campaign_event")
     *
     * @SWG\Post(
     *     path="/campaign-event",
     *     summary="Create a new Campaign Event",
     *     operationId="createCampaignEvent",
     *     tags={"CampaignEvent"},
     *     @SWG\Parameter(
     *         name="CampaignEvent",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CampaignEvent")
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="the created Campaign Event",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/CampaignEventComplete"),
     *                 )
     *             }
     *         )
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
     * @return View
     */
    public function postAction(Request $request)
    {
        $campaignEvent = new CampaignEvent();
        $form = $this->createForm(CampaignEventType::class, $campaignEvent);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($campaignEvent);
        $em->flush();

        return $this->createView($campaignEvent, Response::HTTP_CREATED);
    }

    /**
     * Updates an existing CampaignEvent entity.
     *
     * @Rest\Put("/{id}", name="_put_campaign_event", requirements={"id"="\d+"})
     *
     * @SWG\Put(
     *      path="/campaign-event/{id}",
     *      summary="Update CampaignEvent by id",
     *      operationId="putCampaignEventById",
     *     tags={"CampaignEvent"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="CampaignEvent Id to update"
     *     ),
     *     @SWG\Parameter(
     *         name="campaignEvent",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CampaignEvent")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated CampaignEvent",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/CampaignEventComplete"),
     *                 )
     *             }
     *         )
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
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @Rest\View()
     *
     * @param Request $request
     * @param integer $id
     * @return View
     */
    public function putAction(Request $request, int $id)
    {
        return $this->putOrPatch($request, $id);
    }

    /**
     * Partially updates an existing CampaignEvent entity.
     *
     * @Rest\Patch("/{id}", name="_patch_campaign_event", requirements={"id"="\d+"})
     *
     * @SWG\Patch(
     *      path="/campaign-event/{id}",
     *      summary="Patch CampaignEvent by id",
     *      operationId="patchCampaignEventById",
     *     tags={"CampaignEvent"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="CampaignEvent Id to update"
     *     ),
     *     @SWG\Parameter(
     *         name="campaignEvent",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/CampaignEvent")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="the updated CampaignEvent",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", ref="#/definitions/CampaignEventComplete"),
     *                 )
     *             }
     *         )
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
     *     ),
     *     security={{ "bearer":{} }}
     * )
     *
     * @Rest\View()
     *
     * @param Request $request
     * @param integer $id
     * @return View
     */
    public function patchAction(Request $request, int $id)
    {
        return $this->putOrPatch($request, $id, false);
    }

    /**
     * Handles put or patch action
     *
     * @param Request $request
     * @param int $id CampaignEvent ID
     * @param bool $clearMissing
     *
     * @return View
     */
    private function putOrPatch(Request $request, int $id, bool $clearMissing = true)
    {
        $em = $this->getDoctrine()->getManager();
        $dataInput = $request->request->all();

        $campaignEvent = $em->getRepository('MarketingBundle:CampaignEvent')->find($id);
        if (!$campaignEvent) {
            throw $this->createNotFoundException('CampaignEvent not found');
        }

        $form = $this->createForm(CampaignEventType::class, $campaignEvent);
        $form->submit($dataInput, $clearMissing);
        //validate
        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em->persist($campaignEvent);
        $em->flush();

        return $this->createView($campaignEvent);
    }
}
