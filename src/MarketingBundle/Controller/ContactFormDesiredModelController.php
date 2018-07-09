<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Enum\PaginateEnum;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class ContactFormDesiredModelController
 * @package MarketingBundle\Controller
 * @Route("contact-form-desired-model")
 */
class ContactFormDesiredModelController extends MullenloweRestController
{
    const CONTEXT = 'ContactFormDesiredModel';

    /**
     * @Rest\Get("/{contactFormId}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/contact-form-desired-model/{contactFormId}",
     *     summary="Get Desired Models for a contactForm",
     *     operationId="getContactFormDesiredModel",
     *     tags={"ContactFormDesiredModel"},
     *     @SWG\Parameter(
     *         name="contactFormId",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="Desired Model ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="ContactFormDesiredModels",
     *         @SWG\Definition(ref="#/definitions/ContactFormDesiredModelContextMulti")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     *
     *
     * @param Request $request
     * @param int     $contactFormId
     * @return View
     */
    public function cgetAction(Request $request, int $contactFormId)
    {
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:ContactFormDesiredModel');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->findBy(['contactForm' => $contactFormId]),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
