<?php

use Codeception\Test\Unit;
use OfferBundle\Entity\OfferAftersale;
use OfferBundle\Entity\OfferFormType;
use OfferBundle\Entity\OfferSubtype;
use OfferBundle\Entity\OfferType;
use OfferBundle\Validator\Constraints\OfferDates;
use OfferBundle\Validator\Constraints\OfferDatesValidator;
use Symfony\Component\Validator\Context\ExecutionContext;

/**
 * Class OfferDatesValidatorTest
 */
class OfferDatesValidatorTest extends Unit
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
        $this->validator = new OfferDatesValidator();
        $translator = $this->getMockBuilder('Symfony\Component\Translation\TranslatorInterface')->getMock();
        $validator = $this->getMockBuilder('Symfony\Component\Validator\Validator\ValidatorInterface')->getMock();

        $this->context = new ExecutionContext($validator, '', $translator);

        $this->context->setConstraint(new OfferDates());
        $this->validator->initialize($this->context);

        //Date
        $this->date = new DateTime('now');
    }

    /**
     * Check :
     *  - startDate > today
     *  - endDate > startDate
     *  - diff startDate and endDate >=3 days and diff startDate and endDate <=92 days
     */
    public function testValidDatesOk()
    {
        $this->offer
            ->setStartDate($this->date->add(new DateInterval('P1D'))->format('Y-m-d'))
            ->setEndDate($this->date->add(new DateInterval('P10D'))->format('Y-m-d'));

        $this->validator->validate($this->offer, new OfferDates());

        $this->assertEquals(0, count($this->context->getViolations()));
    }

    /**
     * Check :
     *  - diff startDate endDate > 92 days
     */
    public function testValidDatesRangeToLarge()
    {
        //Date range to large
        $this->offer
            ->setStartDate($this->date->add(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($this->date->add(new DateInterval('P100D'))->format('Y-m-d'));

        $this->validator->validate($this->offer, new OfferDates());

        $this->assertEquals(1, count($this->context->getViolations()));
    }

    /**
     * Check :
     *  - diff startDate endDate < 3 days
     */
    public function testValidDatesRangeToSmall()
    {
        $this->offer
            ->setStartDate($this->date->add(new DateInterval('P10D'))->format('Y-m-d'))
            ->setEndDate($this->date->add(new DateInterval('P1D'))->format('Y-m-d'));

        $this->validator->validate($this->offer, new OfferDates());

        $this->assertEquals('1', count($this->context->getViolations()));
    }
}
