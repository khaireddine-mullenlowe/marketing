<?php
namespace OfferBundle\Controller;

use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
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
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="array", @SWG\Items(ref="#definitions/Subtype"))
     *                 )
     *             }
     *         )
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
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Definition(ref="#/definitions/Context"),
     *                 @SWG\Definition(
     *                     @SWG\Property(property="data", type="object",
     *                         allOf={
     *                             @SWG\Definition(ref="#definitions/Subtype")
     *                         }
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *
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

        return $this->createView($subtype);
    }
}
