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
 * @Route("partner/type")
 */
class OfferTypeController extends MullenloweRestController
{
    const CONTEXT = 'OfferType';

    /**
     * @Rest\Get("/{category}")
     * @Rest\View()
     *
     * @param string $category
     * @return View
     *
     * @SWG\Get(
     *     path="/offer/partner/type/{category}",
     *     summary="Get Types",
     *     operationId="getTypes",
     *     tags={"Type"},
     *     @SWG\Parameter(
     *         name="category",
     *         in="path",
     *         type="string",
     *         required=true,
     *         description="Category name : AFTERSALE, SECONDHANDCAR, NEWCAR"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Get types",
     *         @SWG\Definition(ref="#/definitions/TypeContextMulti")
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

        if (empty($types)) {
            throw new NotFoundHttpException(static::CONTEXT, 'Types not found');
        }

        return $this->createView($types);
    }
}
