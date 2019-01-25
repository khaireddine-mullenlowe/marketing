[1mdiff --git a/app/DoctrineMigrations/Version20190125172810.php b/app/DoctrineMigrations/Version20190125172810.php[m
[1mindex b554d22..ba9d76d 100755[m
[1m--- a/app/DoctrineMigrations/Version20190125172810.php[m
[1m+++ b/app/DoctrineMigrations/Version20190125172810.php[m
[36m@@ -17,7 +17,7 @@[m [mclass Version20190125172810 extends AbstractMullenloweMigration[m
     const CAMPAIGN_TYPE_APV = 'External Campaign Event';[m
     const CAMPAIGN_TYPE_DEFAULT = 'Campagne Externe';[m
     const HEADERS = ["provider", "external_campaign_number", "model_id", "contact_form_id"];[m
[31m-    const SIMPLE_FORM_ID = 1112;[m
[32m+[m[32m    const SIMPLE_FORM_NAME = "2019_FilRouge_Display_Desktop";[m
 [m
     /**[m
      * @param Schema $schema[m
[36m@@ -34,7 +34,7 @@[m [mclass Version20190125172810 extends AbstractMullenloweMigration[m
 [m
         $em = $this->getEntityManager();[m
         $simpleContactForm = $em->getRepository("MarketingBundle:ContactForm")[m
[31m-            ->find(SELF::SIMPLE_FORM_ID);[m
[32m+[m[32m            ->findBy(['name' => SELF::SIMPLE_FORM_NAME]);[m
 [m
         foreach ($csv as $line => $row) {[m
             if (!$line) {[m
[36m@@ -82,12 +82,14 @@[m [mclass Version20190125172810 extends AbstractMullenloweMigration[m
             $externalCampaignEvent = $em[m
                 ->getRepository("MarketingBundle:ExternalCampaignEvent")[m
                 ->findOneBy([[m
[31m-                    "provider"                  =>  $row['provider'],[m
[31m-                    "providerCampaignNumber"    =>  $row['external_campaign_number'],[m
[31m-                    "modelId"                   =>  $row['model_id'],[m
[32m+[m[32m                    "provider" => $row['provider'],[m
[32m+[m[32m                    "providerCampaignNumber" => $row['external_campaign_number'],[m
[32m+[m[32m                    "modelId" => $row['model_id'],[m
                 ]);[m
 [m
[31m-            if ($externalCampaignEvent) $em->remove($externalCampaignEvent);[m
[32m+[m[32m            if ($externalCampaignEvent) {[m
[32m+[m[32m                $em->remove($externalCampaignEvent);[m
[32m+[m[32m            }[m
         }[m
 [m
         $em->flush();[m
[1mdiff --git a/src/MarketingBundle/Controller/ExternalCampaignEventController.php b/src/MarketingBundle/Controller/ExternalCampaignEventController.php[m
[1mindex e74daf1..54a8395 100755[m
[1m--- a/src/MarketingBundle/Controller/ExternalCampaignEventController.php[m
[1m+++ b/src/MarketingBundle/Controller/ExternalCampaignEventController.php[m
[36m@@ -61,7 +61,6 @@[m [mclass ExternalCampaignEventController extends MullenloweRestController[m
             ->find($id);[m
 [m
         if (empty($campaignEvent)) {[m
[31m-[m
             throw new NotFoundHttpException(self::CONTEXT, 'External Compaing Event not found.');[m
         }[m
 [m
[1mdiff --git a/src/MarketingBundle/Entity/ContactForm.php b/src/MarketingBundle/Entity/ContactForm.php[m
[1mindex d9b89fd..89b5b00 100755[m
[1m--- a/src/MarketingBundle/Entity/ContactForm.php[m
[1m+++ b/src/MarketingBundle/Entity/ContactForm.php[m
[36m@@ -39,7 +39,7 @@[m [mclass ContactForm[m
     protected $campaignEvent;[m
 [m
     /**[m
[31m-     * @var ExternalCampaignEvent[m
[32m+[m[32m     * @var ArrayCollection[m
      *[m
      * @ORM\OneToMany([m
      *     targetEntity="ExternalCampaignEvent",[m
[1mdiff --git a/src/MarketingBundle/Entity/ExternalCampaignEvent.php b/src/MarketingBundle/Entity/ExternalCampaignEvent.php[m
[1mindex a814871..2e7c351 100755[m
[1m--- a/src/MarketingBundle/Entity/ExternalCampaignEvent.php[m
[1m+++ b/src/MarketingBundle/Entity/ExternalCampaignEvent.php[m
[36m@@ -30,7 +30,6 @@[m [mclass ExternalCampaignEvent extends BaseEntity[m
      * @var string[m
      * @Assert\NotNull[m
      *[m
[31m-     *[m
      * @ORM\Column(name="provider", type="text", nullable=false)[m
      */[m
     protected $provider;[m
[36m@@ -61,14 +60,14 @@[m [mclass ExternalCampaignEvent extends BaseEntity[m
      */[m
     protected $contactForm;[m
 [m
[31m-    /**src/MarketingBundle/Entity/ExternalCampaignEvent.php[m
[32m+[m[32m    /**[m
      * Set provider[m
      *[m
      * @param string $provider[m
      *[m
      * @return ExternalCampaignEvent[m
      */[m
[31m-    public function setProvider(string $provider)[m
[32m+[m[32m    public function setProvider($provider)[m
     {[m
         $this->provider = $provider;[m
 [m
[36m@@ -97,7 +96,7 @@[m [mclass ExternalCampaignEvent extends BaseEntity[m
      * @param string $providerCampaignNumber[m
      * @return $this[m
      */[m
[31m-    public function setProviderCampaignNumber(string $providerCampaignNumber)[m
[32m+[m[32m    public function setProviderCampaignNumber($providerCampaignNumber)[m
     {[m
         $this->providerCampaignNumber = $providerCampaignNumber;[m
 [m
[36m@@ -116,7 +115,7 @@[m [mclass ExternalCampaignEvent extends BaseEntity[m
      * @param ContactForm $contactForm[m
      * @return $this[m
      */[m
[31m-    public function setContactForm(ContactForm $contactForm)[m
[32m+[m[32m    public function setContactForm($contactForm)[m
     {[m
         $this->contactForm = $contactForm;[m
 [m
[1mdiff --git a/tests/functional/OfferBundle/Controller/OfferFundingControllerCest.php b/tests/functional/OfferBundle/Controller/OfferFundingControllerCest.php[m
[1mindex 90b54f2..59f4163 100755[m
[1m--- a/tests/functional/OfferBundle/Controller/OfferFundingControllerCest.php[m
[1m+++ b/tests/functional/OfferBundle/Controller/OfferFundingControllerCest.php[m
[36m@@ -117,6 +117,8 @@[m [mclass OfferFundingControllerCest[m
 [m
     public function trySearch(FunctionalTester $I)[m
     {[m
[32m+[m[32m        sleep(1);[m
[32m+[m
         $I->sendGET('/offer/funding/search?q=myFundingOffer');[m
         $I->seeResponseCodeIs(Response::HTTP_OK);[m
         $I->seeResponseContains('pagination');[m
