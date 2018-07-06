<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
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
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }
}
