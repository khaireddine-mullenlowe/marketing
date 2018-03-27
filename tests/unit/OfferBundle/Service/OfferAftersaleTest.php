<?php

use Codeception\Test\Unit;
use OfferBundle\Entity\OfferAftersale as Offer;
use OfferBundle\Entity\OfferFormType;
use OfferBundle\Entity\OfferSubtype;
use OfferBundle\Entity\OfferType;
use OfferBundle\Repository\OfferAftersaleRepository;
use OfferBundle\Service\OfferAftersale;
use Symfony\Component\Validator\Validation;

/**
 * Class OfferAftersaleTest
 */
class OfferAftersaleTest extends Unit
{
    protected $repository;
    protected $formType;
    protected $type;
    protected $subtype;
    protected $date;

    /**
     * Initialisation
     */
    public function setUp()
    {
        $this->repository = $this->getMockBuilder(OfferAftersaleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->formType = new OfferFormType();
        $this->formType->setName('basic')->setType('BASIC');
        $this->type = new OfferType();
        $this->type->setName('Entretien')->setSubtitle('sous titre')->setCategory('AFTERSALE');
        $this->subtype = new OfferSubtype();
        $this->subtype->setName('Test')->setType($this->type)->setFormType($this->formType)->setRank(1);

        $this->date = new DateTime('now');
    }

    public function testConstructorAftersaleOffer()
    {
        $offer = new Offer($this->subtype);

        $date = new \DateTime('now');

        $this->assertEquals($date->format('y-m-d'), $offer->getCreatedAt()->format('y-m-d'));
        $this->assertEquals($date->format('y-m-d'), $offer->getUpdatedAt()->format('y-m-d'));
        $this->assertEquals(1, $offer->getStatus());
    }

    /**
     * Check :
     *  - startDate > today
     *  - endDate > startDate
     *  - diff startDate and endDate >=3 days and diff startDate and endDate <=92 days
     */
    public function testValidDatesOk()
    {
        $offer = new Offer($this->subtype);

        $offer
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

    /**
     * Check :
     *  - diff startDate endDate > 92 days
     *  - diff startDate endDate < 3 days
     *  - startDate < today
     */
    public function testValidDatesKo()
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $offer = new Offer($this->subtype);

        $offer
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

    /**
     * Check :
     *  formType :
     *      - BASIC  : no discount
     *      - SIMPLE : discount simple filled
     *      - DOUBLE : discount simple and double filled
     *      - TRIPLE : discount simple, double and triple filled
     */
    public function testValidDiscountOk()
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $date = new DateTime('now');
        $offer = new Offer($this->subtype);
        $offer
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
        $offer->setDiscountSimple('10');
        $this->assertEquals(count($validator->validate($offer)), 0);

        //Type DOULBLE = discount 1 and 2 only
        $this->formType->setType('DOUBLE');
        $offer->setDiscountDouble('20');
        $this->assertEquals(count($validator->validate($offer)), 0);

        //Type TRIPLE = discount 1 2 and 3
        $this->formType->setType('TRIPLE');
        $offer->setDiscountTriple('30');
        $this->assertEquals(count($validator->validate($offer)), 0);
    }

    /**
     * Check :
     *  formType :
     *      - BASIC  : with a discount
     *      - SIMPLE : discount simple empty, discount double filled
     *      - DOUBLE : discount simple empty, discount triple filled
     *      - TRIPLE : discount simple empty
     */
    public function testValidDiscountKo()
    {
        $validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();

        $date = new DateTime('now');
        $offer = new Offer($this->subtype);
        $offer
            ->setDescription('Description')
            ->setAgreements(1)
            ->setDetails('Détails')
            ->setTerms('ML')
            ->setTitle('Titre')
            ->setStartDate($date->add(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($date->add(new DateInterval('P40D'))->format('Y-m-d'));

        //Type BASIC = no discount
        //Too much discount
        $offer->setDiscountSimple('10')->setDiscountDouble('10');
        $this->assertEquals(count($validator->validate($offer)), 1);

        //Type SIMPLE = discount 1 only
        //Too much discount
        $this->formType->setType('SIMPLE');
        $this->assertEquals(count($validator->validate($offer)), 1);
        //DiscountSimple empty
        $offer->setDiscountSimple('');
        $this->assertEquals(count($validator->validate($offer)), 1);

        //Type DOULBLE = discount 1 and 2 only
        //Discount 1 empty
        $this->formType->setType('DOUBLE');
        $offer->setDiscountDouble('20');
        $this->assertEquals(count($validator->validate($offer)), 1);
        //Too much discount
        $offer->setDiscountSimple('10')->setDiscountTriple('30');
        $this->assertEquals(count($validator->validate($offer)), 1);

        //Type TRIPLE = discount 1 2 and 3
        //Discount 1 empty
        $this->formType->setType('TRIPLE');
        $offer->setDiscountSimple('')->setDiscountTriple('30');
        $this->assertEquals(count($validator->validate($offer)), 1);
    }
}