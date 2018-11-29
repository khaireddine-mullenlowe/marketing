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
class Version20181128172939 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const IMPORT_FILENAME = 'id_forms_ecom_2018.xlsx';

    /** @var EntityManager */
    private $em;

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function up(Schema $schema)
    {
        $this->initEntityManager();
        $importPath = $this->getExcelPath();

        $this->parseContactFormExcel($importPath, function($cells, $rowKey) {
            $campaignEvent = $this->createCampaignIfNeeded($cells);
            $this->createContactForm($campaignEvent, $cells);

            // Insert per batch of 40 in case of performance issues
            if ($rowKey % 40 === 0) {
                $this->em->flush();
            }
        });

        $this->em->flush();
    }

    /**
     * @param Schema $schema
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function down(Schema $schema)
    {
        $this->initEntityManager();
        $importPath = $this->getExcelPath();

        $this->parseContactFormExcel($importPath, function($cells, $rowKey) {
            $this->deleteContactForm($cells);

            // For performance issues
            if ($rowKey % 40 === 0) {
                $this->em->flush();
            }
        });
        $this->em->flush();
    }

    /**
     * @param $importPath
     * @param $callback
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    private function parseContactFormExcel($importPath, $callback)
    {
        $spreadsheet = IOFactory::load($importPath);
        $rows = $spreadsheet->getActiveSheet()->rangeToArray('A1:S3');

        if (!empty($rows[0])) {
            $columnDefinition = array_shift($rows);
            foreach ($rows as $rowKey => $row) {
                $reindexedRow = array_combine($columnDefinition, $row);

                // Call to delete/import rows is made by the parent function
                $callback($reindexedRow, $rowKey);
            }
        }
    }

    /**
     * @param $data
     * @return CampaignEvent|null|object
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createCampaignIfNeeded($data)
    {
        $campaignRepo = $this->em->getRepository('MarketingBundle:CampaignEvent');

        if (!empty($data['campaign_legacy_id'])) {
            $campaignByLegacyId = $campaignRepo->findOneBy(['legacyId' => $data['campaign_legacy_id']]);
            if (!empty($campaignByLegacyId)) {
                return $campaignByLegacyId;
            }
        }

        if (!empty($data['campaign_name'])) {
            $campaignByName = $campaignRepo->findOneBy(['name' => $data['campaign_name']]);
            if (!empty($campaignByName)) {
                return $campaignByName;
            }
        }

        $eventTypeRepo = $this->em->getRepository('MarketingBundle:EventType');
        if (isset($data['campaign_name']) && !is_null($data['campaign_name'])) {
            $eventType = $eventTypeRepo->findOneBy(['name' => $data['campaign_type']]);
        }

        $campaign = new CampaignEvent();
        if (!empty($data['campaign_name'])) {
            $campaign
                ->setName($data['campaign_name'])
                ->setEventType($eventType)
                ->setWaitingList($data['waiting_list'])
                ->setStartDate(\DateTime::createFromFormat('m/d/Y', '01/01/2018'))
                ->setEndDate(\DateTime::createFromFormat('m/d/Y', $data['end_date']))
                ->setStatus(1);
            $this->em->persist($campaign);
            $this->em->flush();
        }

        return $campaign;
    }

    /**
     * @param $campaignEvent
     * @param array $data
     */
    private function createContactForm($campaignEvent, $data)
    {
        $contactFormTypeRepo = $this->em->getRepository('MarketingBundle:ContactFormType');
        $subscriptionRepo = $this->em->getRepository('MarketingBundle:Subscription');
        $entryPointRepo = $this->em->getRepository('MarketingBundle:EntryPoint');
        $leadProviderRepo = $this->em->getRepository('MarketingBundle:LeadProvider');

        if (
            !empty($data['form_type']) &&
            !empty($data['subscription']) &&
            !empty($data['entry_point']) &&
            !empty($data['provider'])
        ) {
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

            $this->em->persist($contactForm);
        }
    }

    /**
     * @param $data
     */
    private function deleteContactForm($data)
    {
        $contactFormRepo = $this->em->getRepository('MarketingBundle:ContactForm');

        $contactForms = $contactFormRepo->findBy(['name' => $data['operation_details']]);
        foreach ($contactForms as $contactForm) {
            $this->em->remove($contactForm);
        }
    }

    /**
     * EntityManager setter
     */
    private function initEntityManager()
    {
        if (!$this->container->has('doctrine')) {
            throw new \LogicException('Doctrine is required for this migration');
        }

        $this->em = $this->container->get('doctrine')->getManager();
    }

    /**
     * @return string
     */
    private function getExcelPath(): string
    {
        $rootDir = $this->container->getParameter('kernel.root_dir');
        $importPath = $rootDir . '/../src/MarketingBundle/Resources/' . self::IMPORT_FILENAME;

        return $importPath;
    }
}
