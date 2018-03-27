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
     *
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
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Id",
     *         @SWG\Property(property="id", type="integer"),
     *         required={"id"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="TimestampableEntity",
     *         @SWG\Property(property="createdAt", type="string", format="date-time", default="now"),
     *         @SWG\Property(property="updatedAt", type="string", format="date-time", default="now")
     *     ),
     *
     *     @SWG\Definition(
     *         definition="TimestampableOfferEntity",
     *         @SWG\Property(property="startDate", type="string", format="y-m-d"),
     *         @SWG\Property(property="endDate", type="string", format="y-m-d"),
     *         required={"startDate", "endDate"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Description",
     *         @SWG\Property(property="description", type="string"),
     *         required={"description"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Terms",
     *         @SWG\Property(property="terms", type="string"),
     *         required={"terms"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferBaseAttributes",
     *         @SWG\Property(property="agreement", type="integer", description="1 or 0"),
     *         @SWG\Property(property="title", type="string"),
     *         @SWG\Property(property="visual", type="string", description="visual name"),
     *         @SWG\Property(property="subtype", type="integer", description="subtype id"),
     *         @SWG\Property(property="partner", type="integer", description="partner id"),
     *         required={"agreement", "title", "visual", "subtype", "partner"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferAftersaleAttributes",
     *         @SWG\Property(property="details", type="string"),
     *         @SWG\Property(property="discountSimple", type="string", description="required according to the subtype"),
     *         @SWG\Property(property="discountDouble", type="string", description="required according to the subtype"),
     *         @SWG\Property(property="discountTriple", type="string", description="required according to the subtype"),
     *         required={"details"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferSaleAttributes",
     *         @SWG\Property(property="monthly", type="float"),
     *         @SWG\Property(property="model", type="integer", description="model id of the vehicle"),
     *         @SWG\Property(property="xPosition", type="float", description="the abscissa of the div block that contains prices"),
     *         @SWG\Property(property="yPosition", type="float", description="the ordinate of the div block that contains prices"),
     *         required={"monthly", "model", "xPosition", "yPosition"}
     *     ),
     *
     *     @SWG\definition(
     *         definition="OfferAftersale",
     *         @SWG\Property(property="offer", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/TimestampableOfferEntity"),
     *                 @SWG\Definition(ref="#definitions/OfferBaseAttributes"),
     *                 @SWG\Definition(ref="#definitions/Description"),
     *                 @SWG\Definition(ref="#definitions/Terms"),
     *                 @SWG\Definition(ref="#definitions/OfferAftersaleAttributes")
     *             }
     *         )
     *     ),
     *
     *     @SWG\definition(
     *         definition="OfferSale",
     *         @SWG\Property(property="offer", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/TimestampableOfferEntity"),
     *                 @SWG\Definition(ref="#definitions/OfferBaseAttributes"),
     *                 @SWG\Definition(ref="#definitions/Description"),
     *                 @SWG\Definition(ref="#definitions/Terms"),
     *                 @SWG\Definition(ref="#definitions/OfferSaleAttributes")
     *             }
     *         )
     *     ),
     *
     *     @SWG\definition(
     *         definition="OfferAftersaleComplete",
     *         @SWG\Property(property="status", type="integer", default="1"),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/TimestampableEntity"),
     *             @SWG\Definition(ref="#definitions/TimestampableOfferEntity"),
     *             @SWG\Definition(ref="#definitions/OfferBaseAttributes"),
     *             @SWG\Definition(ref="#definitions/Description"),
     *             @SWG\Definition(ref="#definitions/Terms"),
     *             @SWG\Definition(ref="#definitions/OfferAftersaleAttributes")
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Name",
     *         @SWG\Property(property="name", type="string")
     *     ),
     *
     *     @SWG\definition(
     *         definition="Type",
     *         @SWG\Property(property="category", type="string"),
     *         @SWG\Property(property="subtitle", type="string"),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/Name"),
     *         }
     *     ),
     *
     *     @SWG\definition(
     *         definition="FormType",
     *         @SWG\Property(property="type", type="string"),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/Description"),
     *             @SWG\Definition(ref="#definitions/Name"),
     *         }
     *     ),
     *
     *     @SWG\definition(
     *         definition="Subtype",
     *         @SWG\Property(property="rank", type="string"),
     *         @SWG\Property(property="type", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/Type")
     *             }
     *         ),
     *         @SWG\Property(property="formType", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/FormType")
     *             }
     *         ),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/Terms"),
     *             @SWG\Definition(ref="#definitions/Name")
     *         }
     *     )
     * )
     */
}
