<?php

namespace MarketingBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use MarketingBundle\Entity\MyaudiUserMarketingObjective;
use MarketingBundle\Form\MyaudiUserMarketingObjectiveType;
use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class MyaudiUserMarketingObjectiveController
 * @package MarketingBundle\Controller
 * @Route("myaudiUserMarketingObjective")
 */
class MyaudiUserMarketingObjectiveController extends MullenloweRestController
{
    const CONTEXT = 'myaudiUserMarketingObjective';

    /**
     * @Rest\Get("/{userId}", requirements={"id"="\d+"})
     * @Rest\View()
     *
     * @param Request $request
     * @param int     $userId
     * @return View
     */
    public function cgetAction(Request $request, int $userId)
    {
        $repository = $this->getDoctrine()->getRepository('MarketingBundle:MyaudiUserMarketingObjective');

        $paginator = $this->get('knp_paginator');
        /** @var SlidingPagination $pager */
        $pager = $paginator->paginate(
            $repository->findBy(['myaudiUserId' => $userId]),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->createPaginatedView($pager);
    }

    /**
     * @Rest\Post("/")
     * @Rest\View()
     *
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $data = $request->request->all();

        $myaudiUserMarketingObjective = new MyaudiUserMarketingObjective();

        $form = $this->createForm(MyaudiUserMarketingObjectiveType::class, $myaudiUserMarketingObjective);

        $form->submit($data);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for offer");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($myaudiUserMarketingObjective);
        $em->flush();

        return $this->createView($myaudiUserMarketingObjective);
    }

    /**
     * @Rest\Put("/")
     * @Rest\View()
     *
     * @param Request $request
     * @return View
     */
    public function putAction(Request $request)
    {
        $data = $request->request->all();

        $myaudiUserMarketingObjective = $this->getDoctrine()->getRepository('MarketingBundle:MyaudiUserMarketingObjective')
                ->findOneBy(['myaudiUserId' => $data['myaudiUserId'], 'marketingObjective' => $data['marketingObjective']]);

        $form = $this->createForm(MyaudiUserMarketingObjectiveType::class, $myaudiUserMarketingObjective);

        $form->submit($data);

        if (!$form->isSubmitted()) {
            throw new BadRequestHttpException(static::CONTEXT, "Form fields are not valid for offer");
        } elseif (!$form->isValid()) {
            return $this->view($form);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($myaudiUserMarketingObjective);
        $em->flush();

        return  $this->createView($myaudiUserMarketingObjective);
    }
}
