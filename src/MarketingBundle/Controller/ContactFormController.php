<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Enum\PaginateEnum;
use MarketingBundle\Form\ContactFormImportType;
use MarketingBundle\Service\ContactFormService;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Mullenlowe\CommonBundle\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;

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
     * @Rest\Get("/search/")
     * @Rest\View()
     *
     * @SWG\Get(
     *     path="/contact-form/search/",
     *     summary="Get ContactForm by criteria",
     *     operationId="getContactFormByCriteria",
     *     tags={"ContactForm"},
     *     @SWG\Parameter(
     *         name="name",
     *         in="query",
     *         type="string",
     *         required=false,
     *         description="ContactForm Name"
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
     *     ),
     *     @SWG\Response(
     *         response=500,
     *         description="System error"
     *     )
     * )
     *
     * @param Request $request
     * @return View
     */
    public function getByCriteriaAction(Request $request)
    {
        try {
            $repositoryManager = $this->get('fos_elastica.manager');
            $repository = $repositoryManager->getRepository('MarketingBundle:ContactForm');

            $criterias = [];
            if ($request->query->get("name")) {
                $criterias["name"] = $request->query->get("name");
            }
            if ($request->query->get("legacyFormId")) {
                $criterias["legacyId"] = $request->query->get("legacyFormId");
            }

            return $this->createView($repository->findOneBy($criterias));
        } catch (\Exception $e) {
            throw new BadRequestHttpException(self::CONTEXT, $e->getMessage());
        }
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
            $request->query->getInt('page', PaginateEnum::CURRENT_PAGE),
            $request->query->getInt('limit', PaginateEnum::LIMIT),
            ['wrap-queries' => true]
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/import/")
     * @Rest\View()
     *
     * @SWG\Post(
     *     path="/import/",
     *     summary="Import contact forms by excel",
     *     operationId="importContactForm",
     *     tags={"ContactForm"},
     *     @SWG\Parameter(
     *         name="ContactFormImportPayload",
     *         in="formData",
     *         type="file",
     *         required=true,
     *         description="",
     *         @SWG\Schema(ref="#/definitions/ContactFormImportPayload")
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Subscription",
     *         @SWG\Definition(ref="#/definitions/ContactFormImportContextMulti")
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
     * @param ContactFormService $contactFormService
     * @return View
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function importAction(ContactFormService $contactFormService, Request $request)
    {
        $form = $this->createForm(ContactFormImportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactForms = $contactFormService->importContactFormByXslx($form->get('file')->getData());

            return $this->createView($contactForms, Response::HTTP_CREATED);
        }

        return $this->view($form, RESPONSE::HTTP_BAD_REQUEST);
    }


}
