<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Entity\ContactForm;
use MarketingBundle\Entity\ExternalCampaignEvent;
use MarketingBundle\Enum\PaginateEnum;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ExternalCampaignEventController
 * @package MarketingBundle\Controller
 * @Route("external-campaign-event")
 */
class ExternalCampaignEventController extends MullenloweRestController
{
    const CONTEXT = 'ExternalCampaignEvent';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/external-campaign-event/{id}",
     *     summary="Get ExternalCampaignEvent",
     *     operationId="getExternalCampaignEvent",
     *     tags={"ExternalCampaignEvent"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="ExternalCampaignEvent ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A ExternalCampaignEvent",
     *         @SWG\Definition(ref="#/definitions/ExternalCampaignEventContext")
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
        $em = $this->getDoctrine()->getManager();

        $externalCampaignEvent = new ExternalCampaignEvent();
        $externalCampaignEvent->setModelId(3);
        $externalCampaignEvent->setProvider("odity");
        $externalCampaignEvent->setProviderCampaignId("20190117");

        $contactForm = new ContactForm();
        $contactForm->setExternalCampaignEvent($externalCampaignEvent);
        $contactForm->setName('test-poc-fil-rouge');
        $contactForm->setDescription('poc');

        $externalCampaignEvent->addContactForm($contactForm);

        $em->persist($externalCampaignEvent);
        $em->persist($contactForm);
        $em->flush();

        die();

        $campaignEvent = $this->getDoctrine()
            ->getRepository('MarketingBundle:ExternalCampaignEvent')
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
     *     path="/external-campaign-event",
     *     summary="Get ExternalCampaignEvents",
     *     operationId="getExternalCampaignEvents",
     *     tags={"CampaignEvent"},
     *     @SWG\Response(
     *         response="200",
     *         description="ExternalCampaignEvents",
     *         @SWG\Definition(ref="#/definitions/ExternalCampaignEventContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:ExternalCampaignEvent');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('externalCampaignEvent'),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
