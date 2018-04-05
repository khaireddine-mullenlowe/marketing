<?php

namespace Tests\unit\OfferBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use OfferBundle\Entity\OfferFunding;
use OfferBundle\Validator\Constraints\OfferFundingUnique;
use OfferBundle\Validator\Constraints\OfferFundingUniqueValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class OfferFundingUniqueValidatorTest extends ConstraintValidatorTestCase
{

    protected $em;
    protected $repository;
    /** @var OfferFunding */
    protected $offerFunding;

    protected function createValidator()
    {
        $this->offerFunding = new OfferFunding();
        $this->offerFunding
            ->setLabel('test')
            ->setActive(true)
            ->setDetails('Lorem ipsum')
            ->setGuaranteed(false)
            ->setLegalNotice('dolor sit amet')
            ->setMaintained(true)
            ->setPrice('15000')
            ->setModelId('1320')
            ->setRangeId('325')
            ->setType(OfferFunding::TYPES[0])
            ->setStartDate((new \DateTime())->add(new \DateInterval('P20D'))->format('Y-m-d'))
            ->setEndDate((new \DateTime())->add(new \DateInterval('P40D'))->format('Y-m-d'))
        ;

        $this->em = $this->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = $this->getMockBuilder(ObjectRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository->expects($this->any())
            ->method('findOneBy')
            ->willReturn($this->offerFunding);

        $this->em->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->repository);

        return new OfferFundingUniqueValidator($this->em);
    }

    public function testNoViolationPeriodeAfter()
    {
        $funding = clone $this->offerFunding;
        $funding->setStartDate(
            $funding->getEndDate()->add(new \DateInterval('P2D'))->format('Y-m-d'));

        $funding->setEndDate(
            $funding->getStartDate()->add(new \DateInterval('P10D'))->format('Y-m-d'));

        $this->validator->validate($funding, new OfferFundingUnique());

        $this->assertNoViolation();
    }

    public function testNoViolationPeriodeBefore()
    {
        $funding = clone $this->offerFunding;
        $funding->setStartDate(
            $funding->getStartDate()->sub(new \DateInterval('P10D'))->format('Y-m-d'));

        $endDate = clone $funding->getStartDate();
        $funding->setEndDate(
            $endDate->add(new \DateInterval('P2D'))->format('Y-m-d'));

        $this->validator->validate($funding, new OfferFundingUnique());

        $this->assertNoViolation();
    }

    public function testStartDateInPeriodViolation()
    {
        $funding = clone $this->offerFunding;
        $funding->setStartDate(
            $this->offerFunding->getStartDate()->add(new \DateInterval('P1D'))->format('Y-m-d'));

        $this->validator->validate($funding, new OfferFundingUnique(['message' => 'My Message']));

        $this->buildViolation('My Message')
            ->setParameter('{{ value }}', $funding->getLabel())
            ->assertRaised();
    }

    public function testEndDateInPeriodViolation()
    {
        $funding = clone $this->offerFunding;
        $funding->setStartDate(
            $funding->getStartDate()->sub(new \DateInterval('P10D'))->format('Y-m-d'));

        $funding->setEndDate(
            $this->offerFunding->getStartDate()->add(new \DateInterval('P1D'))->format('Y-m-d'));

        $this->validator->validate($funding, new OfferFundingUnique(['message' => 'My Message']));

        $this->buildViolation('My Message')
            ->setParameter('{{ value }}', $funding->getLabel())
            ->assertRaised();
    }

    public function testNewPeriodTooLargeViolation()
    {
        $funding = clone $this->offerFunding;
        $funding->setStartDate(
            $funding->getStartDate()->sub(new \DateInterval('P10D'))->format('Y-m-d'));

        $funding->setEndDate(
            $funding->getEndDate()->add(new \DateInterval('P1D'))->format('Y-m-d'));

        $this->validator->validate($funding, new OfferFundingUnique(['message' => 'My Message']));

        $this->buildViolation('My Message')
            ->setParameter('{{ value }}', $funding->getLabel())
            ->assertRaised();
    }

}