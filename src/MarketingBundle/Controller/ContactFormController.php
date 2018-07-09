<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class ContactFormController
 * @package MarketingBundle\Controller
 * @Route("contact-form")
 */
class ContactFormController extends MullenloweRestController
{
    const CONTEXT = 'ContactForm';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/contact-form/{id}",
     *     summary="Get ContactForm",
     *     operationId="getContactForm",
     *     tags={"ContactForm"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="ContactForm ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A ContactForm",
     *         @SWG\Definition(ref="#/definitions/ContactFormContext")
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
        $contactForm = $this->getDoctrine()
            ->getRepository('MarketingBundle:ContactForm')
            ->find($id);

        if (empty($contactForm)) {
            throw $this->createNotFoundException('ContactForm not found');
        }

        return $this->createView($contactForm);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/contact-form",
     *     summary="Get ContactForms",
     *     operationId="getContactForms",
     *     tags={"ContactForm"},
     *     @SWG\Response(
     *         response="200",
     *         description="ContactForms",
     *         @SWG\Definition(ref="#/definitions/ContactFormContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:ContactForm');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('contactForm'),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10),
            ['wrap-queries' => true]
        );

        return $this->createPaginatedView($pager);
    }
}
