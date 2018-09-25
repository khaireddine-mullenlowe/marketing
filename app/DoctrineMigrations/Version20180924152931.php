<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use MarketingBundle\Entity\CampaignEvent;
use MarketingBundle\Entity\ContactForm;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180924152931 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    const CAMPAIGN_NAME = '2018_MondialAutoParis_réservation';
    const CAMPAIGN_EVENT_TYPE = 'Campagne';

    const SUBSCRIPTION_NAME = 'eCommerce';
    const OPERATION_NAME = '2018_MondialAutoParis_ReservationCPL';
    const ENTRYPOINT_NAME = 'Evénement';
    const CONTACTFORM_TYPE_LABEL = 'normal_contact_form_type_id';

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $campaignEvent = $this->createCampaignPMS();
        $this->createContactForm($campaignEvent);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $em = $this->getEntityManager();
        $contactFormRepo = $em->getRepository('MarketingBundle:ContactForm');
        $campaignRepo = $em->getRepository('MarketingBundle:CampaignEvent');

        $contactForm = $contactFormRepo->findOneBy(['name' => self::OPERATION_NAME]);
        $em->remove($contactForm);
        $em->flush();
        $campaign = $campaignRepo->findOneBy(['name' => self::CAMPAIGN_NAME]);
        $em->remove($campaign);
        $em->flush();

    }

    /**
     * @return CampaignEvent
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createCampaignPMS()
    {
        $em = $this->getEntityManager();
        $eventTypeRepo = $em->getRepository('MarketingBundle:EventType');
        $eventType = $eventTypeRepo->findOneBy(['name' => self::CAMPAIGN_EVENT_TYPE]);

        $campaign = new CampaignEvent();
        $campaign
            ->setName(self::CAMPAIGN_NAME)
            ->setEventType($eventType)
            ->setWaitingList(0)
            ->setStartDate(\DateTime::createFromFormat('d/m/Y', '24/09/2018'))
            ->setEndDate(\DateTime::createFromFormat('d/m/Y', '31/12/2018'))
            ->setStatus(1);
        $em->persist($campaign);
        $em->flush();

        return $campaign;
    }

    /**
     * @param $campaignEvent
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createContactForm($campaignEvent)
    {
        $em = $this->getEntityManager();
        $contactFormTypeRepo = $em->getRepository('MarketingBundle:ContactFormType');
        $subscriptionRepo = $em->getRepository('MarketingBundle:Subscription');
        $entryPointRepo = $em->getRepository('MarketingBundle:EntryPoint');

        $contactFormType = $contactFormTypeRepo->findOneBy(['name' => self::CONTACTFORM_TYPE_LABEL]);
        $subscription = $subscriptionRepo->findOneBy(['name' => self::SUBSCRIPTION_NAME]);
        $entryPoint = $entryPointRepo->findOneBy(['name' => self::ENTRYPOINT_NAME]);

        $contactForm = new ContactForm();
        $contactForm
            ->setName(self::OPERATION_NAME)
            ->setDescription(self::OPERATION_NAME)
            ->setContactFormType($contactFormType)
            ->setSubscription($subscription)
            ->setEntryPoint($entryPoint)
            ->setCampaignEvent($campaignEvent)
            ->setCreateProspectAccount(1)
            ->setSendEmailToCdv(1)
            ->setSendEmailToCrm(1);
        $em->persist($contactForm);
        $em->flush();
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
