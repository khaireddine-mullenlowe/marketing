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
     *         @SWG\Property(property="agreements", type="integer", description="1 or 0"),
     *         @SWG\Property(property="title", type="string"),
     *         @SWG\Property(property="visual", type="string", description="visual name"),
     *         @SWG\Property(property="subtype", type="integer", description="subtype id"),
     *         @SWG\Property(property="partnerId", type="integer", description="partner id"),
     *         required={"agreements", "title", "visual", "subtype", "partnerId"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferBaseCompleteAttributes",
     *         @SWG\Property(property="agreements", type="integer", description="1 or 0"),
     *         @SWG\Property(property="title", type="string"),
     *         @SWG\Property(property="visual", type="string", description="visual name"),
     *         @SWG\Property(property="partnerId", type="integer", description="partner id"),
     *         @SWG\Property(property="subtype", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/Subtype"),
     *             },
     *         ),
     *         required={"agreements", "title", "visual", "subtype", "partnerId"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferAftersaleAttributes",
     *         @SWG\Property(property="details", type="string"),
     *         @SWG\Property(
     *             property="discountSimple",
     *             type="number",
     *             type="number",
     *             format="float",
     *             description="required according to the subtype"
     *         ),
     *         @SWG\Property(
     *             property="discountDouble",
     *             type="number",
     *             format="float",
     *             description="required according to the subtype"
     *         ),
     *         @SWG\Property(
     *             property="discountTriple",
     *             type="number",
     *             format="float",
     *             description="required according to the subtype"
     *         ),
     *         required={"details"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferAftersaleTerms",
     *         @SWG\Property(property="km", type="integer")
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferSaleAttributes",
     *         @SWG\Property(
     *             property="monthly",
     *             type="number",
     *             format="float"
     *         ),
     *         @SWG\Property(
     *             property="modelId",
     *             type="integer",
     *             description="model id of the vehicle"),
     *         @SWG\Property(
     *             property="xPosition",
     *             type="number",
     *             format="float",
     *             description="the abscissa of the div block that contains prices"
     *         ),
     *         @SWG\Property(
     *             property="yPosition",
     *             type="number",
     *             format="float",
     *             description="the ordinate of the div block that contains prices"
     *         ),
     *         required={"monthly", "modelId", "xPosition", "yPosition"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferSecondhandCarTerms",
     *         @SWG\Property(property="modelName", type="string"),
     *         @SWG\Property(property="engine", type="string"),
     *         @SWG\Property(property="email", type="string"),
     *         @SWG\Property(property="address", type="string")
     *     ),
     *
     *     @SWG\Definition(
     *          definition="OfferNewCarTerms",
     *          @SWG\Property(property="monthNumber", type="integer"),
     *          @SWG\Property(
     *              property="advancePayment",
     *              type="number",
     *              format="float"
     *          ),
     *          @SWG\Property(property="priceDate", type="string", format="y-m-d"),
     *          @SWG\Property(property="modelName", type="string"),
     *          @SWG\Property(property="engine", type="string"),
     *          @SWG\Property(property="options", type="string"),
     *          @SWG\Property(property="rangeName", type="string"),
     *          @SWG\Property(
     *              property="mgpMin",
     *              type="number",
     *              format="float"
     *          ),
     *          @SWG\Property(
     *              property="mgpMax",
     *              type="number",
     *              format="float"
     *          ),
     *          @SWG\Property(
     *              property="co2EmissionMin",
     *              type="number",
     *              format="float"
     *          ),
     *          @SWG\Property(
     *              property="co2EmissionMax",
     *              type="number",
     *              format="float"
     *          ),
     *          @SWG\Property(property="maximumKm", type="integer"),
     *          @SWG\Property(property="partner", type="string")
     *      ),
     *
     *     @SWG\Definition(
     *         definition="OfferAftersale",
     *         @SWG\Property(property="offer", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/TimestampableOfferEntity"),
     *                 @SWG\Definition(ref="#definitions/OfferBaseAttributes"),
     *                 @SWG\Definition(ref="#definitions/Description"),
     *                 @SWG\Definition(ref="#definitions/Terms"),
     *                 @SWG\Definition(ref="#definitions/OfferAftersaleAttributes")
     *             }
     *         ),
     *         @SWG\Property(property="terms", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/OfferAftersaleTerms")
     *             }
     *         )
     *     ),
     *
     *     @SWG\Definition(
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
     *     @SWG\Definition(
     *         definition="OfferSecondhandCar",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/OfferSale")
     *         },
     *         @SWG\Property(property="terms", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/OfferSecondhandCarTerms")
     *             }
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferNewCar",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/OfferSale")
     *         },
     *         @SWG\Property(property="terms", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/OfferNewCarTerms")
     *             }
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferAftersaleComplete",
     *         @SWG\Property(property="status", type="integer", default="1"),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/TimestampableEntity"),
     *             @SWG\Definition(ref="#definitions/TimestampableOfferEntity"),
     *             @SWG\Definition(ref="#definitions/OfferBaseCompleteAttributes"),
     *             @SWG\Definition(ref="#definitions/Description"),
     *             @SWG\Definition(ref="#definitions/OfferAftersaleAttributes"),
     *             @SWG\Definition(ref="#definitions/OfferAftersaleTerms")
     *         },
     *         @SWG\Property(property="termProperty", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/OfferAftersaleTerms")
     *             }
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferAftersaleContext",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Context")
     *         },
     *         @SWG\Property(property="data", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/OfferAftersaleComplete")
     *             }
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferAftersaleContextMulti",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Context")
     *         },
     *         @SWG\Property(property="data", type="array",
     *             @SWG\Items(ref="#definitions/OfferAftersaleComplete")
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferUpdate",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/Description"),
     *         },
     *         @SWG\Property(property="subtype", type="integer", description="subtype id"),
     *         @SWG\Property(property="endDate", type="string", format="y-m-d"),
     *         @SWG\Property(property="visual", type="string")
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferSaleComplete",
     *         @SWG\Property(property="status", type="integer", default="1"),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/TimestampableEntity"),
     *             @SWG\Definition(ref="#definitions/TimestampableOfferEntity"),
     *             @SWG\Definition(ref="#definitions/OfferBaseCompleteAttributes"),
     *             @SWG\Definition(ref="#definitions/Description"),
     *             @SWG\Definition(ref="#definitions/OfferSaleAttributes")
     *         },
     *         @SWG\Property(property="termsProperty", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/OfferNewCarTerms")
     *             }
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferSaleContext",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Context")
     *         },
     *         @SWG\Property(property="data", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/OfferSaleComplete")
     *             }
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Name",
     *         @SWG\Property(property="name", type="string")
     *     ),
     *
     *     @SWG\Definition(
     *         definition="Type",
     *         @SWG\Property(property="category", type="string"),
     *         @SWG\Property(property="subtitle", type="string"),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/Name"),
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="TypeContextMulti",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Context")
     *         },
     *         @SWG\Property(property="data", type="array",
     *             @SWG\Items(ref="#definitions/Type")
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="FormType",
     *         @SWG\Property(property="type", type="string"),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/Description"),
     *             @SWG\Definition(ref="#definitions/Name"),
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="TermsTemplate",
     *         @SWG\Property(property="template", type="string"),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id")
     *         },
     *         required={"template"}
     *     ),
     *
     *     @SWG\Definition(
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
     *         @SWG\Property(property="termsTemplate", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/TermsTemplate")
     *             }
     *         ),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/Name")
     *         }
     *     ),
     *
     *     @SWG\Definition(
     *         definition="SubtypeContext",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Context")
     *         },
     *         @SWG\Property(property="data", type="object",
     *             allOf={
     *                 @SWG\Definition(ref="#definitions/Subtype")
     *             }
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="SubtypeContextMulti",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Context")
     *         },
     *         @SWG\Property(property="data", type="array",
     *             @SWG\Items(ref="#definitions/Subtype")
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="MyaudiUsers",
     *         @SWG\Property(property="myaudiUserIds", type="array",
     *             @SWG\Items(type="integer")
     *         ),
     *         @SWG\Property(property="id", type="integer"),
     *         @SWG\Property(property="subtype", type="integer"),
     *         required={"myaudiUserId", "id", "subtype"}
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferAftersaleMyaudiUserContext",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Context")
     *         },
     *         @SWG\Property(property="data", type="object",
     *             @SWG\Property(property="status", type="string")
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferFunding",
     *         @SWG\Property(
     *             property="funding",
     *             allOf={
     *                  @SWG\Definition(ref="#definitions/TimestampableOfferEntity"),
     *                  @SWG\Definition(ref="#definitions/OfferFundingAttributes")
     *             }
     *         )
     *
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferFundingAttributes",
     *         @SWG\Property(
     *             property="type",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="label",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="modelId",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="rangeId",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="price",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="withContribution",
     *             type="boolean"
     *         ),
     *         @SWG\Property(
     *             property="guaranteed",
     *             type="boolean"
     *         ),
     *         @SWG\Property(
     *             property="maintained",
     *             type="boolean"
     *         ),
     *         @SWG\Property(
     *             property="details",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="legalNotice",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="visual",
     *             type="string"
     *         ),
     *         @SWG\Property(
     *             property="active",
     *             type="boolean"
     *         )
     *     ),
     *
     *     @SWG\Definition(
     *         definition="OfferFundingComplete",
     *         @SWG\Property(property="status", type="integer", default="1"),
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Id"),
     *             @SWG\Definition(ref="#definitions/TimestampableOfferEntity"),
     *             @SWG\Definition(ref="#definitions/OfferFundingAttributes")
     *         }
     *     )
     * )
     */
}
