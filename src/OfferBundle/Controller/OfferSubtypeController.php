<?php
namespace OfferBundle\Controller;

use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Mullenlowe\CommonBundle\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Swagger\Annotations as SWG;

/**
 * Class OfferTypeController
 * @Route("partner/subtype")
 */
class OfferSubtypeController extends MullenloweRestController
{
    const CONTEXT = 'OfferSubtype';

    /**
     * @Rest\Get("/type/{typeId}")
     * @Rest\View()
     *
     * @param int $typeId
     * @return View
     *
     * @SWG\Get(
     *     path="/offer/partner/subtype/type/{typeId}",
     *     summary="Get Subtypes",
     *     operationId="getSubtypes",
     *     tags={"Subtype"},
     *     @SWG\Parameter(
     *         name="typeId",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="Type Id"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Get subtypes",
     *         @SWG\Definition(ref="#/definitions/SubtypeContextMulti")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function cgetAction(int $typeId)
    {
        $em = $this->getDoctrine();
        $subtypes = $em->getRepository("OfferBundle:OfferSubtype")->findBy(['type' => $typeId]);

        if (empty($subtypes)) {
            throw new NotFoundHttpException(static::CONTEXT, 'Subtypes not found');
        }

        return $this->createView($subtypes);
    }

    /**
     * @Rest\Get("/{id}")
     * @Rest\View()
     *
     * @param int $id
     * @return View
     *
     * @SWG\Get(
     *     path="/offer/partner/subtype/{id}",
     *     summary="Get Subtype",
     *     operationId="getSubtype",
     *     tags={"Subtype"},
     *     @SWG\Parameter(
     *         name="id",
     *         in="path",
     *         type="integer",
     *         required=true,
     *         description="Subtype Id"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Get subtype",
     *         @SWG\Definition(ref="#/definitions/SubtypeContext")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="not found",
     *         @SWG\Schema(ref="#/definitions/Error")
     *     )
     * )
     */
    public function getAction(int $id)
    {
        $em = $this->getDoctrine();
        $subtype = $em->getRepository("OfferBundle:OfferSubtype")->find($id);

        if (empty($subtype)) {
            throw new NotFoundHttpException(static::CONTEXT, 'Subtype not found');
        }

        return $this->createView($subtype);
    }
}
