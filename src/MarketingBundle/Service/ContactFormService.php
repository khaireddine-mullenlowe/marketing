<?php
namespace MarketingBundle\Service;

use Doctrine\ORM\EntityManager;
use MarketingBundle\Entity\CampaignEvent;
use MarketingBundle\Entity\ContactForm;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ContactFormService
 * @package MarketingBundle\Service
 */
class ContactFormService
{

    private $em;

    /**
     * ContactFormService constructor.
     * @param $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param $file
     * @return array
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function importContactFormByXslx(UploadedFile $file)
    {
        /** @var ContactForm[] $contactForms */
        $contactForms = [];
        $this->parseContactFormExcel($file->getPathname(), function($cells) use(&$contactForms) {
            $campaignEvent = $this->createCampaignIfNeeded($cells);
            $contactForm = $this->createContactForm($campaignEvent, $cells);
            $contactForms[] = [
                'id' => $contactForm->getId(),
                'name' => $contactForm->getName(),
                'description' => $contactForm->getDescription()
            ];
        });
        unlink($file->getPathname());

        return $contactForms;
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
        $rowIterator = $spreadsheet->getActiveSheet()->getRowIterator();
        $columnDefinition = [];

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
        }
    }

    /**
     * @param array $data
     * @return CampaignEvent|null|object
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createCampaignIfNeeded($data)
    {
        $campaignRepo = $this->em->getRepository('MarketingBundle:CampaignEvent');

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

        $eventTypeRepo = $this->em->getRepository('MarketingBundle:EventType');
        $eventType = $eventTypeRepo->findOneBy(['name' => $data['campaign_type']]);

        $campaign = new CampaignEvent();
        $campaign
            ->setName($data['campaign_name'])
            ->setEventType($eventType)
            ->setWaitingList($data['waiting_list'])
            ->setStartDate(\DateTime::createFromFormat('d/m/Y', $data['end_date']))
            ->setEndDate(\DateTime::createFromFormat('d/m/Y', $data['end_date']))
            ->setStatus(1);
        $this->em->persist($campaign);
        $this->em->flush();

        return $campaign;
    }

    /**
     * @param CampaignEvent $campaignEvent
     * @param array $data
     * @return ContactForm
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createContactForm(CampaignEvent $campaignEvent, $data)
    {
        $contactFormTypeRepo = $this->em->getRepository('MarketingBundle:ContactFormType');
        $subscriptionRepo = $this->em->getRepository('MarketingBundle:Subscription');
        $entryPointRepo = $this->em->getRepository('MarketingBundle:EntryPoint');
        $leadProviderRepo = $this->em->getRepository('MarketingBundle:LeadProvider');

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
        $this->em->flush();

        return $contactForm;
    }

}