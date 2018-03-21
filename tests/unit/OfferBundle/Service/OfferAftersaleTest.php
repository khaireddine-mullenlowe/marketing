<?php

use Codeception\Test\Unit;
use OfferBundle\Entity\OfferAftersale as Offer;
use OfferBundle\Entity\OfferFormType;
use OfferBundle\Entity\OfferSubtype;
use OfferBundle\Entity\OfferType;
use OfferBundle\Repository\OfferAftersaleRepository;
use OfferBundle\Service\OfferAftersale;
use Symfony\Component\Validator\Validation;

class OfferAftersaleTest extends Unit
{
    protected $service;
    protected $repository;
    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    protected $kernel;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    protected $container;

    protected $formType;
    protected $type;
    protected $subtype;
    protected $date;

    public function setUp()
    {
        $this->repository = $this->getMockBuilder(OfferAftersaleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        //Only for the service constructor
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();
        $this->entityManager = ($this->kernel->getContainer())->get('doctrine')->getManager();

        $this->service = new OfferAftersale($this->entityManager);

        $this->formType = new OfferFormType();
        $this->formType->setName('basic')->setType('BASIC');
        $this->type = new OfferType();
        $this->type->setName('Entretien')->setSubtitle('sous titre')->setCategory('AFTERSALE');
        $this->subtype = new OfferSubtype();
        $this->subtype->setName('Test')->setType($this->type)->setFormType($this->formType)->setRank(1);

        $this->date = new DateTime('now');
    }

    public function testCheckSubtypeOk()
    {
        $res = $this->service->checkSubtype(['subtype' => 1]);

        $this->assertEquals('AFTERSALE', $res['type']);
        $this->assertTrue($res['subtype'] instanceof OfferSubtype);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCheckSubtypeKo()
    {
        $res = $this->service->checkSubtype(['subtype' => 0]);
    }

    public function testValidDatesOk()
    {
        $offer = new Offer($this->subtype);

        $offer
            ->setSubtitle('Sous-titre')
            ->setDescription('Description')
            ->setAgreements(1)
            ->setDetails('Détails')
            ->setTerms('ML')
            ->setTitle('Titre')
            ->setStartDate($this->date->add(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($this->date->add(new DateInterval('P40D'))->format('Y-m-d'));

        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
        $this->assertEquals(count($validator->validate($offer)), 0);
    }

    public function testValidDatesKo()
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $offer = new Offer($this->subtype);

        $offer
            ->setSubtitle('Sous-titre')
            ->setDescription('Description')
            ->setAgreements(1)
            ->setDetails('Détails')
            ->setTerms('ML')
            ->setTitle('Titre');

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

    public function testValidDiscountOk()
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $date = new DateTime('now');
        $offer = new Offer($this->subtype);
        $offer
            ->setSubtitle('Sous-titre')
            ->setDescription('Description')
            ->setAgreements(1)
            ->setDetails('Détails')
            ->setTerms('ML')
            ->setTitle('Titre')
            ->setStartDate($date->add(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($date->add(new DateInterval('P40D'))->format('Y-m-d'));

        //Type BASIC = no discount
        $this->assertEquals(count($validator->validate($offer)), 0);

        //Type SIMPLE = discount 1 only
        $this->formType->setType('SIMPLE');
        $offer->setDiscount1('10');
        $this->assertEquals(count($validator->validate($offer)), 0);

        //Type DOULBLE = discount 1 and 2 only
        $this->formType->setType('DOUBLE');
        $offer->setDiscount2('20');
        $this->assertEquals(count($validator->validate($offer)), 0);

        //Type TRIPLE = discount 1 2 and 3
        $this->formType->setType('TRIPLE');
        $offer->setDiscount3('30');
        $this->assertEquals(count($validator->validate($offer)), 0);
    }

    public function testValidDiscountKo()
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $date = new DateTime('now');
        $offer = new Offer($this->subtype);
        $offer
            ->setSubtitle('Sous-titre')
            ->setDescription('Description')
            ->setAgreements(1)
            ->setDetails('Détails')
            ->setTerms('ML')
            ->setTitle('Titre')
            ->setStartDate($date->add(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($date->add(new DateInterval('P40D'))->format('Y-m-d'));

        //Type BASIC = no discount
        //Too much discount
        $offer->setDiscount1('10')->setDiscount2('10');
        $this->assertEquals(count($validator->validate($offer)), 1);

        //Type SIMPLE = discount 1 only
        //Too much discount
        $this->formType->setType('SIMPLE');
        $this->assertEquals(count($validator->validate($offer)), 1);
        //Discount1 empty
        $offer->setDiscount1('');
        $this->assertEquals(count($validator->validate($offer)), 1);

        //Type DOULBLE = discount 1 and 2 only
        //Discount 1 empty
        $this->formType->setType('DOUBLE');
        $offer->setDiscount2('20');
        $this->assertEquals(count($validator->validate($offer)), 1);
        //Too much discount
        $offer->setDiscount1('10')->setDiscount3('30');
        $this->assertEquals(count($validator->validate($offer)), 1);

        //Type TRIPLE = discount 1 2 and 3
        //Discount 1 empty
        $offer->setDiscount1('')->setDiscount3('30');
        $this->assertEquals(count($validator->validate($offer)), 1);
    }
}