<?php

namespace OfferBundle;

/**
 * Class SwaggerDefinitions
 * @package OfferBundle
 */
class SwaggerDefinitions
{
    /**
     * @SWG\Swagger(
     *     @SWG\Info(
     *         version="1.0.0",
     *         title="Marketing Api"
     *     ),
     *     host="api5.audi.agence-one.net",
     *     basePath="/marketing/",
     *     schemes={"http"},
     *     produces={"application/json"},
     *     @SWG\Definition(
     *         definition="Context",
     *         type="object",
     *         @SWG\Property(property="context", type="string")
     *     ),
     *     @SWG\Definition(
     *         definition="Success",
     *         type="object",
     *         allOf={@SWG\Definition(ref="#/definitions/Context")},
     *         @SWG\Property(
     *             property="data",
     *             type="object",
     *             properties={@SWG\Property(property="message", type="string")}
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Error",
     *         type="object",
     *         allOf={@SWG\Definition(ref="#/definitions/Context")},
     *         @SWG\Property(
     *             property="errors",
     *             type="array",
     *             @SWG\Items(
     *                 @SWG\Property(property="message", type="string"),
     *                 @SWG\Property(property="code", type="integer"),
     *                 @SWG\Property(property="type", type="string"),
     *             )
     *         ),
     *         required={"errors"}
     *     )
     * )
     */
}
