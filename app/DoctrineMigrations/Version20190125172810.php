<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use MarketingBundle\Entity\ExternalCampaignEvent;
use Mullenlowe\CommonBundle\Doctrine\Migration\AbstractMullenloweMigration;

/**
 * Class Version20190125172810
 * @package Application\Migrations
 */
class Version20190125172810 extends AbstractMullenloweMigration
{

    const IMPORT_FILENAME = 'external_campaign_event_1112.csv';
    const CAMPAIGN_TYPE_APV = 'External Campaign Event';
    const CAMPAIGN_TYPE_DEFAULT = 'Campagne Externe';
    const HEADERS = ["provider", "external_campaign_number", "model_id", "contact_form_id"];
    const SIMPLE_FORM_NAME = "2019_FilRouge_Display_Desktop";

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function up(Schema $schema)
    {
        $rootDir = $this->container->getParameter('kernel.root_dir');
        $importPath = $rootDir . '/../src/MarketingBundle/Resources/' . self::IMPORT_FILENAME;

        $csv = array_map('str_getcsv', file($importPath));

        $em = $this->getEntityManager();
        $simpleContactForm = $em->getRepository("MarketingBundle:ContactForm")
            ->findOneBy(['name' => SELF::SIMPLE_FORM_NAME]);

        foreach ($csv as $line => $row) {
            if (!$line) {
                continue;
            }

            $row = array_combine(SELF::HEADERS, $row);
            echo sprintf("Importing %s into external_campaign event\n", var_export($row, true));

            $externalCampaignEvent = new ExternalCampaignEvent();
            $externalCampaignEvent->setProvider($row['provider']);
            $externalCampaignEvent->setProviderCampaignNumber($row['external_campaign_number']);
            $externalCampaignEvent->setModelId($row['model_id']);
            $externalCampaignEvent->setContactForm($simpleContactForm);

            $em->persist($externalCampaignEvent);
        }

        $em->flush();
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function down(Schema $schema)
    {
        $rootDir = $this->container->getParameter('kernel.root_dir');
        $importPath = $rootDir . '/../src/MarketingBundle/Resources/' . self::IMPORT_FILENAME;

        $csv = array_map('str_getcsv', file($importPath));

        $em = $this->getEntityManager();

        foreach ($csv as $line => $row) {
            if (!$line) {
                continue;
            }

            $row = array_combine(SELF::HEADERS, $row);
            echo sprintf("Deleting external_campaign event with values %s \n", var_export($row, true));

            $externalCampaignEvent = $em
                ->getRepository("MarketingBundle:ExternalCampaignEvent")
                ->findOneBy([
                    "provider"                  => $row['provider'],
                    "providerCampaignNumber"    => $row['external_campaign_number'],
                    "modelId"                   => $row['model_id'],
                ]);

            if ($externalCampaignEvent) {
                $em->remove($externalCampaignEvent);
            }
        }

        $em->flush();
    }
}
