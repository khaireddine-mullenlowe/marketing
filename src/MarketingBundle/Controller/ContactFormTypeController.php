<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Enum\PaginateEnum;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * Class ContactFormTypeController
 * @package MarketingBundle\Controller
 * @Route("contact-form-type")
 */
class ContactFormTypeController extends MullenloweRestController
{
    const CONTEXT = 'ContactFormType';

    /**
     * @Rest\Get("/{id}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/contact-form-type/{id}",
     *     summary="Get ContactFormType",
     *     operationId="getContactFormType",
     *     tags={"ContactFormType"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="query",
     *         type="integer",
     *         required=false,
     *         description="ContactFormType ID"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="A ContactFormType",
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
        $contactFormType = $this->getDoctrine()
            ->getRepository('MarketingBundle:ContactFormType')
            ->find($id);

        if (empty($contactFormType)) {
            throw $this->createNotFoundException('ContactFormType not found');
        }

        return $this->createView($contactFormType);
    }

    /**
     * @Rest\Get("/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/contact-form-type",
     *     summary="Get ContactFormTypes",
     *     operationId="getContactFormTypes",
     *     tags={"ContactFormType"},
     *     @SWG\Response(
     *         response="200",
     *         description="ContactFormTypes",
     *         @SWG\Definition(ref="#/definitions/BasicEntityContextMulti")
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
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:ContactFormType');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->createQueryBuilder('contactFormType'),
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT)
        );

        return $this->createPaginatedView($pager);
    }
}
