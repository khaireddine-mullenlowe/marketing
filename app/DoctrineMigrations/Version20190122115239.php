<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use MarketingBundle\Entity\ContactForm;
use Mullenlowe\CommonBundle\Doctrine\Migration\AbstractMullenloweMigration;

/**
 * Class Version20190122115239
 * Remove duplicate ecommerce apv contact form
 *
 * @package Application\Migrations
 */
class Version20190122115239 extends AbstractMullenloweMigration
{
    const CONTACTACT_FORM_NAME = 'e-commerce_apv';

    /** @var EntityManager */
    private $em;

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->em = $this->getEntityManager();
        $contactForm = $this->em
            ->getRepository(ContactForm::class)
            ->createQueryBuilder('cf')
            ->andWhere('cf.name = :name')
            ->andWhere('cf.legacyId is not null')
            ->setParameter('name', self::CONTACTACT_FORM_NAME)
            ->getQuery()
            ->getResult()
        ;

        if ($contactForm instanceof ContactForm) {
            $this->em->remove($contactForm);
            $this->em->flush();
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
