<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use MarketingBundle\Entity\CampaignEvent;
use MarketingBundle\Entity\ContactForm;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181025122821 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const IMPORT_FILENAME = 'id_forms_2018_v3.xlsx';

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

        $this->parseContactFormExcel($importPath, function($cells) {
            $campaignEvent = $this->createCampaignIfNeeded($cells);
            $this->createContactForm($campaignEvent, $cells);
        });
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

        $this->parseContactFormExcel($importPath, function($cells) {
            $this->deleteContactForm($cells);
        });
    }

    /**
     * @param $importPath
     * @param $callback
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function parseContactFormExcel($importPath, $callback)
    {
        $spreadsheet = IOFactory::load($importPath);
        $rowIterator = $spreadsheet->getActiveSheet()->getRowIterator();
        $columnDefinition = [];
        $em = $this->getEntityManager();

        foreach ($rowIterator as $rowKey => $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            $cells = [];

            foreach ($cellIterator as $keyCell => $cell) {
                $key = $keyCell;
                if (!empty($columnDefinition) && isset($columnDefinition[$keyCell])) {
                    $key = $columnDefinition[$keyCell];
                }
                $cells[$key] = $cell->getFormattedValue();
            }

            // Do not import first row
            if ($rowKey === 1) {
                $columnDefinition = $cells;
            } else {
                // Call to delete/import rows is made by the parent function
                $callback($cells);
            }

            // For performance issues
            if ($rowKey % 40 === 0) {
                $em->flush();
            }
        }

        $em->flush();
    }

    /**
     * @param $data
     * @return CampaignEvent|null|object
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createCampaignIfNeeded($data)
    {
        $em = $this->getEntityManager();

        $campaignRepo = $em->getRepository('MarketingBundle:CampaignEvent');

        if (isset($data['campaign_legacy_id'])) {
            $campaignByLegacyId = $campaignRepo->findOneBy(['legacyId' => $data['campaign_legacy_id']]);
            if (!empty($campaignByLegacyId)) {
                return $campaignByLegacyId;
            }
        }

        if (isset($data['campaign_name'])) {
            $campaignByName = $campaignRepo->findOneBy(['name' => $data['campaign_name']]);
            if (!empty($campaignByName)) {
                return $campaignByName;
            }
        }

        $eventTypeRepo = $em->getRepository('MarketingBundle:EventType');
        $eventType = $eventTypeRepo->findOneBy(['name' => $data['campaign_type']]);

        $campaign = new CampaignEvent();
        $campaign
            ->setName($data['campaign_name'])
            ->setEventType($eventType)
            ->setWaitingList($data['waiting_list'])
            ->setStartDate(\DateTime::createFromFormat('d/m/Y', '01/01/2018'))
            ->setEndDate(\DateTime::createFromFormat('d/m/Y', $data['end_date']))
            ->setStatus(1);
        $em->persist($campaign);
        $em->flush();

        return $campaign;
    }

    /**
     * @param $campaignEvent
     * @param array $data
     */
    private function createContactForm($campaignEvent, $data)
    {
        $em = $this->getEntityManager();
        $contactFormTypeRepo = $em->getRepository('MarketingBundle:ContactFormType');
        $subscriptionRepo = $em->getRepository('MarketingBundle:Subscription');
        $entryPointRepo = $em->getRepository('MarketingBundle:EntryPoint');
        $leadProviderRepo = $em->getRepository('MarketingBundle:LeadProvider');

        $contactFormType = $contactFormTypeRepo->findOneBy(['name' => $data['form_type']]);
        $subscription = $subscriptionRepo->findOneBy(['name' => $data['subscription']]);
        $entryPoint = $entryPointRepo->findOneBy(['name' => $data['entry_point']]);
        $provider = $leadProviderRepo->findOneBy(['name' => $data['provider']]);

        $contactForm = new ContactForm();
        $contactForm
            ->setName($data['operation_details'])
            ->setDescription($data['operation_details'])
            ->setContactFormType($contactFormType)
            ->setSubscription($subscription)
            ->setEntryPoint($entryPoint)
            ->setLeadProvider($provider)
            ->setCampaignEvent($campaignEvent)
            ->setCreateProspectAccount($data['prospect_account'])
            ->setSendEmailToCdv($data['email_cdv'])
            ->setSendEmailToCrm($data['email_crm']);

        $em->persist($contactForm);
    }

    /**
     * @param $data
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function deleteContactForm($data)
    {
        $em = $this->getEntityManager();
        $contactFormRepo = $em->getRepository('MarketingBundle:ContactForm');

        $contactForm = $contactFormRepo->findOneBy(['name' => $data['operation_details']]);
        if (!empty($contactForm)) {
            $em->remove($contactForm);
        }
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('Doctrine is required for this migration');
        }

        return $this->container->get('doctrine')->getManager();
    }
}
