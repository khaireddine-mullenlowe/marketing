<?php
namespace OfferBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use OfferBundle\Entity\OfferFormType;
use OfferBundle\Entity\OfferSubtype;
use OfferBundle\Entity\OfferType;
use Symfony\Component\Yaml\Yaml;

class OfferFixtures extends Fixture
{
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

            $this->addReference('Type_'. $reference, $offerType);
        }

        foreach ($fixtures['OfferFormType'] as $reference => $column) {
            $offerFormType = new OfferFormType();

            $offerFormType->setName($column['name']);
            $offerFormType->setDescription($column['description']);
            $offerFormType->setType($column['type']);

            $manager->persist($offerFormType);

            $manager->flush();

            $this->addReference('FormType_'. $reference, $offerFormType);
        }

        foreach ($fixtures['OfferSubtype'] as $reference => $column) {
            $offerSubtype = new OfferSubtype();

            $offerSubtype->setName($column['name']);
            $offerSubtype->setTerms($column['terms']);
            $offerSubtype->setRank($column['rank']);
            $offerSubtype->setFormType($this->getReference('FormType_' . $column['formType']));
            $offerSubtype->setType($this->getReference('Type_' . $column['type']));

            $manager->persist($offerSubtype);
        }

        $manager->flush();
    }
}