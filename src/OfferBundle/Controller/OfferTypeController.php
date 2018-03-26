<?php
namespace OfferBundle\Controller;

use Mullenlowe\CommonBundle\Controller\MullenloweRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

/**
 * Class OfferTypeController
 */
class OfferTypeController extends MullenloweRestController
{
    const CONTEXT = 'OfferType';

    /**
     * @Rest\Get("/type/{category}")
     * @Rest\View()
     *
     * @param string $category
     * @return View
     *
     * @SWG\Get(
     *     path="offer/type/{category}",
     *     summary="Get Types",
     *     operationId="getTypes",
     *     tags={"type"},
     *     @SWG\Parameter(
     *         name="category",
     *         in="query",
     *         type="integer",
     *         required="true",
     *         description="Category name"
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
    public function cgetAction(string $category)
    {
        $em = $this->getDoctrine();
        $types = $em->getRepository("OfferBundle:OfferType")->findBy(['category' => strtoupper($category)]);

        return $this->createView($types);
    }
}