<?php

namespace MarketingBundle;

/**
 * Class SwaggerDefinitions
 * @package MarketingBundle
 */
class SwaggerDefinitions
{
    /**
     * @SWG\Definition(
     *     definition="BasicEntity",
     *     @SWG\Property(property="id", type="integer"),
     *     @SWG\Property(property="status", type="integer"),
     *     @SWG\Property(property="name", type="integer"),
     *     allOf={
     *         @SWG\Definition(ref="#definitions/TimestampableEntity")
     *     },
     *     required={"id", "status", "name"}
     * ),
     *
     * @SWG\Definition(
     *     definition="BasicEntityContext",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/BasicEntity")
     *         }
     *    )
     * ),
     *
     * @SWG\Definition(
     *     definition="BasicEntityContextMulti",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="array",
     *         @SWG\Items(ref="#definitions/BasicEntity")
     *    )
     * ),
     *
     * @SWG\Definition(
     *     definition="Score",
     *     @SWG\Property(property="myaudiUserId", type="integer"),
     *     @SWG\Property(property="interest", type="number", format="float"),
     *     @SWG\Property(property="seriousness", type="number", format="float"),
     *     @SWG\Property(property="contactType", type="string", format="INIT, E, D, C, B, S1, S2, S3"),
     *     allOf={
     *         @SWG\Definition(ref="#definitions/TimestampableEntity")
     *     }
     * ),
     *
     * @SWG\Definition(
     *     definition="ScoreContext",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/Score")
     *
     *         }
     *    )
     * ),
     *
     * @SWG\Definition(
     *     definition="ScoreContextMulti",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="array",
     *         @SWG\Items(ref="#definitions/Score")
     *    )
     * ),
     *
     * @SWG\Definition(
     *     definition="CampaignEvent",
     *     @SWG\Property(property="description", type="string"),
     *     @SWG\Property(property="descriptionEvent", type="string"),
     *     @SWG\Property(property="descriptionTarget", type="string"),
     *     @SWG\Property(property="waitingList", type="boolean"),
     *     @SWG\Property(property="eventTypeId", type="integer"),
     *     @SWG\Property(property="startDate", type="string", format="date"),
     *     @SWG\Property(property="endDate", type="string", format="date"),
     *     allOf={
     *         @SWG\Definition(ref="#definitions/BasicEntity")
     *     }
     * ),
     *
     * @SWG\Definition(
     *     definition="CampaignEventContext",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/CampaignEvent")
     *
     *         }
     *    )
     * ),
     *
     * @SWG\Definition(
     *     definition="CampaignEventContextMulti",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="array",
     *         @SWG\Items(ref="#definitions/CampaignEvent")
     *    )
     * ),
     *
     * @SWG\Definition(
     *     definition="ContactForm",
     *     @SWG\Property(property="id", type="integer"),
     *     @SWG\Property(property="campaignEvent", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/CampaignEvent")
     *         }
     *     ),
     *     @SWG\Property(property="subscription", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/BasicEntity")
     *         }
     *     ),
     *     @SWG\Property(property="entryPoint", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/BasicEntity")
     *         }
     *     ),
     *     @SWG\Property(property="name", type="string"),
     *     @SWG\Property(property="description", type="string"),
     *     @SWG\Property(property="createProspectAccount", type="boolean"),
     *     @SWG\Property(property="trackingCodeInit", type="string", format="url"),
     *     @SWG\Property(property="trackingCodeValidation", type="sting", format="url"),
     *     @SWG\Property(property="sendEmailToCrm", type="boolean"),
     *     @SWG\Property(property="sendEmailToCdv", type="boolean"),
     *     @SWG\Property(property="leadProvider", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/BasicEntity")
     *         }
     *     ),
     *     @SWG\Property(property="contactFormType", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/BasicEntity")
     *         }
     *     )
     * ),
     *
     * @SWG\Definition(
     *     definition="ContactFormContext",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/ContactForm")
     *
     *         }
     *     )
     * ),
     *
     * @SWG\Definition(
     *     definition="ContactFormContextMulti",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="array",
     *         @SWG\Items(ref="#definitions/ContactForm")
     *     )
     * ),
     *
     * @SWG\Definition(
     *     definition="ContactFormDesiredModel",
     *     @SWG\Property(property="desiredModelId", type="integer"),
     *     @SWG\Property(property="contactForm", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/ContactForm")
     *         }
     *     )
     * ),
     *
     * @SWG\Definition(
     *     definition="ContactFormDesiredModelContextMulti",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="array",
     *         @SWG\Items(ref="#definitions/ContactFormDesiredModel")
     *     )
     * ),
     *
     * @SWG\Definition(
     *     definition="EntryPointUser",
     *     @SWG\Property(property="id", type="integer"),
     *     @SWG\Property(property="userId", type="integer"),
     *     @SWG\Property(property="entryPoint", type="object",
     *         allOf={
     *              @SWG\Definition(ref="#definitions/BasicEntity")
     *         },
     *     )
     * ),
     *
     * @SWG\Definition(
     *     definition="EntryPointUserContextMulti",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="array",
     *         @SWG\Items(ref="#definitions/EntryPointUser")
     *     )
     * ),
     *
     * @SWG\Definition(
     *     definition="MyaudiUserMarketingObjective",
     *     @SWG\Property(property="myaudiUserId", type="integer"),
     *     @SWG\Property(property="marketingObjective", type="object",
     *         allOf={
     *              @SWG\Definition(ref="#definitions/MarketingObjective")
     *         },
     *     ),
     *     @SWG\Property(property="isUnsubcribe", type="boolean"),
     * ),
     *
     * @SWG\Definition(
     *     definition="MyaudiUserMarketingObjectiveContext",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="object",
     *         allOf={
     *              @SWG\Definition(ref="#definitions/MarketingObjective")
     *         },
     *     )
     * ),
     *
     * @SWG\Definition(
     *     definition="MyaudiUserMarketingObjectiveContextMulti",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="array",
     *         @SWG\Items(ref="#definitions/MyaudiUserMarketingObjective")
     *     )
     * ),
     *
     * @SWG\Definition(
     *     definition="InterestUser",
     *     @SWG\Property(property="myaudiUserId", type="integer"),
     *     @SWG\Property(property="marketingObjective", type="object",
     *         allOf={
     *              @SWG\Definition(ref="#definitions/MarketingObjective")
     *         },
     *     ),
     *     @SWG\Property(property="isUnsubcribe", type="boolean"),
     * ),
     *
     * @SWG\Definition(
     *     definition="InterestUserPayload",
     *     @SWG\Property(property="userId", type="integer"),
     *     @SWG\Property(property="interest", type="integer"),
     * ),
     *
     * @SWG\Definition(
     *     definition="InterestUserContextMulti",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="array",
     *         @SWG\Items(ref="#definitions/InterestUser")
     *     )
     * ),
     * @SWG\Definition(
     *     definition="EventType",
     *     @SWG\Property(property="parentEventType", type="array",
     *         @SWG\Items(ref="#definitions/EventType")
     *     ),
     *     @SWG\Property(property="subEventType", type="array",
     *         @SWG\Items(ref="#definitions/EventType")
     *     ),
     *     allOf={
     *         @SWG\Definition(ref="#definitions/BasicEntity")
     *     }
     * ),
     *
     * @SWG\Definition(
     *     definition="EventTypeContext",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="object",
     *         allOf={
     *             @SWG\Definition(ref="#definitions/EventType")
     *
     *         }
     *    )
     * ),
     *
     * @SWG\Definition(
     *     definition="EventTypeContextMulti",
     *     allOf={
     *         @SWG\Definition(ref="#definitions/Context")
     *     },
     *     @SWG\Property(property="data", type="array",
     *         @SWG\Items(ref="#definitions/EventType")
     *    )
     * )
     */
}
