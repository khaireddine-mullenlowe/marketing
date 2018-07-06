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
