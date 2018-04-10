<?php

namespace OfferBundle\DataFixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use OfferBundle\Entity\OfferFunding;
use Symfony\Component\Yaml\Yaml;

class OfferFundingFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $fixtures = Yaml::parse(file_get_contents(dirname(__FILE__).'/fixtures/offer_funding.yml'));

        foreach ($fixtures['OfferFunding'] as $reference => $columns) {
            $offerFunding = new OfferFunding();
            foreach ($columns as $column=>$value) {
                $setter = 'set' . ucfirst($column);
                $offerFunding->$setter($value);
            }
        }

        $manager->persist($offerFunding);
        $manager->flush();
    }
}