<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use MarketingBundle\Entity\CampaignEvent;
use MarketingBundle\Entity\ContactForm;
use MarketingBundle\Entity\EventType;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Rename Mondial auto 2018 Event.
 */
class Version20181113165310 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /** @var EntityManager */
    private $em;

    const FORM_ID = 587;
    const OLD_CAMPAING_ID = 1001;

    const NEW_CAMPAIGN_NAME = "2018_MondialAutoParis";
    const NEW_CAMPAIGN_CREATED_AT = "2018-10-01 00:00:00";
    const NEW_CAMPAIGN_START_AT = "2018-10-04 00:00:00";
    const NEW_CAMPAIGN_END_AT = "2018-12-31 23:59:59";



    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // Init
        $this->initEntityManager();

        /** @var ContactForm $contactForm */
        $contactForm = $this->em->getRepository(ContactForm::class)->find(self::FORM_ID);

        if (!$contactForm) {
            throw new \LogicException('Contact Form not found.');
        }

        /** @var EventType $eventType */
        $eventType = $this->em->getRepository(EventType::class)->findOneBy(["name" => "Campagne"]);
        if (!$eventType) {
            throw new \LogicException('Event Type not found.');
        }

        $campainEvent = new CampaignEvent();
        $campainEvent
            ->setName(self::NEW_CAMPAIGN_NAME)
            ->setCreatedAt(\DateTime::createFromFormat("Y-m-d H:i:s", self::NEW_CAMPAIGN_CREATED_AT))
            ->setUpdatedAt(\DateTime::createFromFormat("Y-m-d H:i:s", "2018-10-01 00:00:00"))
            ->setStartDate(\DateTime::createFromFormat("Y-m-d H:i:s", self::NEW_CAMPAIGN_START_AT))
            ->setEndDate(\DateTime::createFromFormat("Y-m-d H:i:s", self::NEW_CAMPAIGN_END_AT))
            ->setStatus(1)
            ->setEventType($eventType);
        $contactForm->setCampaignEvent($campainEvent);

        $this->em->persist($campainEvent);
        $this->em->persist($contactForm);
        $this->em->flush();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // Init
        $this->initEntityManager();

        /** @var ContactForm $contactForm */
        $contactForm = $this->em->getRepository(ContactForm::class)->find(self::FORM_ID);

        if (!$contactForm) {
            throw new \LogicException('Contact Form not found.');
        }

        /** @var CampaignEvent $campaignEvent */
        $campaignEvent = $this->em->getRepository(CampaignEvent::class)->findOneBy(
            [
                "name" => self::NEW_CAMPAIGN_NAME,
                "createdAt" => \DateTime::createFromFormat("Y-m-d H:i:s", self::NEW_CAMPAIGN_CREATED_AT),
                "startDate" => \DateTime::createFromFormat("Y-m-d H:i:s", self::NEW_CAMPAIGN_START_AT),
                "endDate" => \DateTime::createFromFormat("Y-m-d H:i:s", self::NEW_CAMPAIGN_END_AT),
            ]
        );

        if (!$campaignEvent) {
            throw new \LogicException('Campaign Event not found.');
        }

        /** @var CampaignEvent $oldCampaignEvent */
        $oldCampaignEvent = $this->em->getRepository(CampaignEvent::class)->find(self::OLD_CAMPAING_ID);
        if (!$oldCampaignEvent) {
            throw new \LogicException(sprintf('Campaign Event not found #%d.', self::OLD_CAMPAING_ID));
        }

        $contactForm->setCampaignEvent($oldCampaignEvent);
        $this->em->remove($campaignEvent);
        $this->em->persist($contactForm);
        $this->em->flush();
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
}
