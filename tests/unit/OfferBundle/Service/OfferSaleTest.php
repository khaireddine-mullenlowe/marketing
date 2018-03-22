<?php

use Codeception\Test\Unit;
use OfferBundle\Entity\OfferFormType;
use OfferBundle\Entity\OfferSubtype;
use OfferBundle\Entity\OfferType;
use OfferBundle\Entity\OfferSale as Offer;
use Symfony\Component\Validator\Validation;

class OfferSaleTest extends Unit
{
    protected $repository;
    protected $formType;
    protected $type;
    protected $subtype;
    protected $date;

    public function setUp()
    {
        $this->repository = $this->getMockBuilder(OfferSaleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->formType = new OfferFormType();
        $this->formType->setName('vn')->setType('SIMPLE');
        $this->type = new OfferType();
        $this->type->setName('A5')->setSubtitle('sous titre')->setCategory('NEWCAR');
        $this->subtype = new OfferSubtype();
        $this->subtype->setName('Test')->setType($this->type)->setFormType($this->formType)->setRank(1);

        $this->date = new DateTime('now');
    }

    public function testValidDatesOk()
    {
        $offer = new Offer($this->subtype);

        $offer
            ->setDescription('Description')
            ->setAgreements(1)
            ->setTerms('ML')
            ->setTitle('Titre')
            ->setStartDate($this->date->add(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($this->date->add(new DateInterval('P40D'))->format('Y-m-d'))
            ->setMonthly('250.99');

        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $this->assertEquals(count($validator->validate($offer)), 0);
    }

    public function testValidDatesKo()
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $offer = new Offer($this->subtype);

        $offer
            ->setDescription('Description')
            ->setAgreements(1)
            ->setTitle('Titre')
            ->setTerms('ML')
            ->setMonthly('250.99');

        //Date range to large
        $offer
            ->setStartDate($this->date->add(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($this->date->add(new DateInterval('P100D'))->format('Y-m-d'));

        $this->assertEquals(count($validator->validate($offer)), 1);

        //Date range to small
        $this->date->sub(new DateInterval('P110D'));
        $offer
            ->setStartDate($this->date->add(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($this->date->add(new DateInterval('P1D'))->format('Y-m-d'));

        $this->assertEquals(count($validator->validate($offer)), 1);

        //Date range to small and dates are before today
        $this->date->sub(new DateInterval('P11D'));
        $offer
            ->setStartDate($this->date->sub(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($this->date->add(new DateInterval('P1D'))->format('Y-m-d'));

        $this->assertEquals(count($validator->validate($offer)), 2);
    }
}