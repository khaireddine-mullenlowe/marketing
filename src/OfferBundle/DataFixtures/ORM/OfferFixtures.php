<?php
namespace OfferBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use OfferBundle\Entity\OfferAftersale;
use OfferBundle\Entity\OfferFormType;
use OfferBundle\Entity\OfferSubtype;
use OfferBundle\Entity\OfferTermsTemplate;
use OfferBundle\Entity\OfferType;
use Symfony\Component\Yaml\Yaml;

/**
 * Class OfferFixtures
 * @package OfferBundle\DataFixtures\ORM
 */
class OfferFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $fixtures = Yaml::parse(file_get_contents(dirname(__FILE__).'/fixtures/offer.yml'));

        foreach ($fixtures['OfferType'] as $reference => $column) {
            $offerType = new OfferType();

            $offerType->setCategory($column['category']);
            $offerType->setName($column['name']);
            $offerType->setSubtitle($column['subtitle']);

            $manager->persist($offerType);
            $manager->flush();

            $this->addReference('Type_'.$reference, $offerType);
        }

        foreach ($fixtures['OfferFormType'] as $reference => $column) {
            $offerFormType = new OfferFormType();

            $offerFormType->setName($column['name']);
            $offerFormType->setDescription($column['description']);
            $offerFormType->setType($column['type']);

            $manager->persist($offerFormType);
            $manager->flush();

            $this->addReference('FormType_'.$reference, $offerFormType);
        }

        foreach ($fixtures['OfferTermsTemplate'] as $reference => $column) {
            $offerTermsTemplate = new OfferTermsTemplate();

            $offerTermsTemplate->setTemplate($column['template']);

            $manager->persist($offerTermsTemplate);
            $manager->flush();

            $this->addReference('TermsTemplate_'.$reference, $offerTermsTemplate);
        }

        foreach ($fixtures['OfferSubtype'] as $reference => $column) {
            $offerSubtype = new OfferSubtype();

            $offerSubtype->setName($column['name']);
            $offerSubtype->setTermsTemplate($this->getReference('TermsTemplate_'.$column['termsTemplate']));
            $offerSubtype->setRank($column['rank']);
            $offerSubtype->setFormType($this->getReference('FormType_'.$column['formType']));
            $offerSubtype->setType($this->getReference('Type_'.$column['type']));

            $manager->persist($offerSubtype);
            $manager->flush();

            $this->addReference('Subtype_'.$reference, $offerSubtype);
        }

        foreach ($fixtures['OfferAftersale'] as $reference => $column) {
            $offerAftersale = new OfferAftersale($this->getReference('Subtype_'.$column['subtype']));

            $offerAftersale->setPartnerId($column['partner']);
            $offerAftersale->setDetails($column['details']);
            $offerAftersale->setStartDate((new \DateTime('now'))->add(new \DateInterval('P2D'))->format('y-m-d'));
            $offerAftersale->setEndDate((new \DateTime('now'))->add(new \DateInterval('P20D'))->format('y-m-d'));
            $offerAftersale->setCreatedAt(new \DateTime('now'));
            $offerAftersale->setUpdatedAt(new \DateTime('now'));
            $offerAftersale->setVisual($column['visual']);
            $offerAftersale->setTitle($column['title']);
            $offerAftersale->setDescription($column['description']);
            $offerAftersale->setAgreements($column['agreements']);
            $offerAftersale->setDiscountSimple($column['discount_simple']);
            $offerAftersale->setDiscountDouble($column['discount_double']);
            $offerAftersale->setDiscountTriple($column['discount_triple']);

            $manager->persist($offerAftersale);
            $manager->flush();
        }
    }
}
