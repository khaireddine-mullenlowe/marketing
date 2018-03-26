<?php
namespace OfferBundle\Controller;

use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * Class OfferTypeController
 */
class OfferSubtypeController extends MullenloweRestController
{
    const CONTEXT = 'OfferSubtype';

    /**
     * @Rest\Get("/subtype/{typeId}")
     * @Rest\View()
     *
     * @param int $typeId
     * @return View
     *
     * @SWG\Get(
     *     path="offer/subtype/{typeId}",
     *     summary="Get Subtypes",
     *     operationId="getSubtypes",
     *     tags={"subtype"},
     *     @SWG\Parameter(
     *         name="type",
     *         in="query",
     *         type="integer",
     *         required="true",
     *         description="Type Id"
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="offers",
     *         @SWG\Schema(ref="#/definitions/Types")
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
}