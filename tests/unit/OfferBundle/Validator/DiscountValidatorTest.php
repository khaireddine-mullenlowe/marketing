<?php

use Codeception\Test\Unit;
use OfferBundle\Entity\OfferAftersale;
use OfferBundle\Entity\OfferFormType;
use OfferBundle\Entity\OfferSubtype;
use OfferBundle\Entity\OfferType;
use OfferBundle\Validator\Constraints\Discount;
use OfferBundle\Validator\Constraints\DiscountValidator;
use Symfony\Component\Validator\Context\ExecutionContext;

/**
 * Class DiscountValidatorTest
 */
class DiscountValidatorTest extends Unit
{
    protected $formType;
    protected $type;
    protected $subtype;
    protected $offer;
    protected $context;
    protected $validator;

    /**
     * Set UP
     */
    public function setUp()
    {
        //FormType, Type and Subtype
        $this->formType = new OfferFormType();
        $this->formType->setName('basic');
        $this->type = new OfferType();
        $this->type->setName('Entretien')->setSubtitle('sous titre')->setCategory('AFTERSALE');
        $this->subtype = new OfferSubtype();
        $this->subtype->setType($this->type)->setFormType($this->formType);
        $this->offer = new OfferAftersale($this->subtype);

        //Validator and Context
        $this->validator = new DiscountValidator();
        $translator = $this->getMockBuilder('Symfony\Component\Translation\TranslatorInterface')->getMock();
        $validator = $this->getMockBuilder('Symfony\Component\Validator\Validator\ValidatorInterface')->getMock();

        $this->context = new ExecutionContext($validator, '', $translator);

        $this->context->setConstraint(new Discount());
        $this->validator->initialize($this->context);
    }

    /**
     * Discount TRIPLE :
     *      - discount simple empty
     *      - discount double empty
     *      - discount triple empty
     */
    public function testDiscountBasicOk()
    {
        $this->offer->getSubtype()->getFormType()->setType('BASIC');

        $this->validator->validate($this->offer, new Discount());

        $this->assertEquals(0, count($this->context->getViolations()));
    }

    /**
     * Discount TRIPLE :
     *      - discount simple filled
     *      - discount double empty
     *      - discount triple empty
     */
    public function testDiscountSimpleOk()
    {
        $this->offer->getSubtype()->getFormType()->setType('SIMPLE');
        $this->offer->setDiscountSimple('99.99');

        $this->validator->validate($this->offer, new Discount());

        $this->assertEquals(0, count($this->context->getViolations()));
    }

    /**
     * Discount TRIPLE :
     *      - discount simple filled
     *      - discount double filled
     *      - discount triple empty
     */
    public function testDiscountDoubleOk()
    {
        $this->offer->getSubtype()->getFormType()->setType('DOUBLE');
        $this->offer->setDiscountSimple('85.52');
        $this->offer->setDiscountDouble('10');

        $this->validator->validate($this->offer, new Discount());

        $this->assertEquals(0, count($this->context->getViolations()));
    }

    /**
     * Discount TRIPLE :
     *      - discount simple filled
     *      - discount double filled
     *      - discount triple filled
     */
    public function testDiscountTripleOk()
    {
        $this->offer->getSubtype()->getFormType()->setType('TRIPLE');
        $this->offer->setDiscountSimple('100');
        $this->offer->setDiscountDouble('20');
        $this->offer->setDiscountTriple('800');

        $this->validator->validate($this->offer, new Discount());

        $this->assertEquals(0, count($this->context->getViolations()));
    }

    /**
     * Discount BASIC :
     *      - discount simple filled
     *      - discount double filled
     *      - discount triple filled
     */
    public function testDiscountBasicKo()
    {
        $this->offer->getSubtype()->getFormType()->setType('BASIC');
        $this->offer->setDiscountSimple('100');
        $this->offer->setDiscountDouble('20');
        $this->offer->setDiscountTriple('800');

        $this->validator->validate($this->offer, new Discount());

        $this->assertEquals(1, count($this->context->getViolations()));
    }

    /**
     * Discount SIMPLE :
     *      - discount simple empty
     *      - discount double filled
     *      - discount triple filled
     */
    public function testDiscountSimpleKo()
    {
        $this->offer->getSubtype()->getFormType()->setType('SIMPLE');
        $this->offer->setDiscountSimple('100');
        $this->offer->setDiscountDouble('20');
        $this->offer->setDiscountTriple('800');

        $this->validator->validate($this->offer, new Discount());

        $this->assertEquals(1, count($this->context->getViolations()));
    }

    /**
     * Discount SIMPLE :
     *      - discount simple empty
     *      - discount double empty
     *      - discount triple filled
     */
    public function testDiscountDoubleKo()
    {
        $this->offer->getSubtype()->getFormType()->setType('DOUBLE');
        $this->offer->setDiscountTriple('800');

        $this->validator->validate($this->offer, new Discount());

        $this->assertEquals(1, count($this->context->getViolations()));
    }

    /**
     * Discount SIMPLE :
     *      - discount simple empty
     *      - discount double empty
     *      - discount triple empty
     */
    public function testDiscountTripleKo()
    {
        $this->offer->getSubtype()->getFormType()->setType('TRIPLE');

        $this->validator->validate($this->offer, new Discount());

        $this->assertEquals(1, count($this->context->getViolations()));
    }
}
