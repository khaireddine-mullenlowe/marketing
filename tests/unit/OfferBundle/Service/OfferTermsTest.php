<?php

use Codeception\Test\Unit;
use DateTime;
use OfferBundle\Entity\OfferFormType;
use OfferBundle\Entity\OfferSale;
use OfferBundle\Entity\OfferSubtype;
use OfferBundle\Entity\OfferType;
use OfferBundle\Form\OfferAftersaleTermsType;
use OfferBundle\Form\OfferNewCarTermsType;
use OfferBundle\Form\OfferSecondhandCarTermsType;
use OfferBundle\Service\OfferTerms;

/**
 * Class OfferTermsTest
 */
class OfferTermsTest extends Unit
{
    /** @var OfferTerms $service */
    protected $service;
    protected $offer;
    protected $form;
    protected $formType;
    protected $type;
    protected $subtype;

    /**
     * Initialisation
     */
    public function setUp()
    {
        $this->service = new OfferTerms();
        $this->formType = new OfferFormType();
        $this->formType->setName('basic')->setType('BASIC');
        $this->type = new OfferType();
        $this->type->setName('Entretien')->setSubtitle('sous titre');
        $this->subtype = new OfferSubtype();
        $this->subtype->setName('Test')->setType($this->type)->setFormType($this->formType)->setRank(1);
    }

    public function testGenerateAftersaleTermsOk()
    {
        $this->type->setCategory('AFTERSALE');
        $this->subtype->setTerms('Offre jusqu\'au #endDate#, et jusqu\'à #km# km.');

        $endDate = (new DateTime('now'))->add(new DateInterval('P30D'));

        $data = [
            'terms' => [
                'km' => '30000',
            ],
            'offer' => [
                'startDate' => (new DateTime('now'))->add(new DateInterval('P3D')),
                'endDate' => $endDate,
            ],
        ];

        $form = $this
            ->getMockBuilder(OfferAftersaleTermsType::class)
            ->disableOriginalConstructor()
            ->setMethods(['submit', 'isValid', 'getData'])
            ->getMock();

        $form->method('submit');
        $form->method('isValid')->will($this->returnValue(true));
        $form->method('getData')->will($this->returnValue([
            'km' => '30 000',
            'endDate' => strftime('%d %B %Y', strtotime($endDate->format('y-m-d'))),
        ]));

        $res = $this->service->generateNewTerms($form, $data, $this->subtype);

        $this->assertEquals(
            'Offre jusqu\'au '.strftime(
                "%d %B %Y",
                strtotime($endDate->format("y-m-d"))
            ).', et jusqu\'à 30 000 km.',
            $res
        );
    }

    public function testGenerateSecondhandCarTermsOk()
    {
        $this->type->setCategory('SECONDHANDCAR');
        $this->subtype->setTerms(
            'Offre jusqu\'au #endDate# pour un modèle #modelName# #engine#. 
            Contact par mail : #email# ou par courrier #address#'
        );

        $endDate = (new DateTime('now'))->add(new DateInterval('P30D'));

        $data = [
            'terms' => [
                'modelName' => 'Audi A5 Sportback',
                'engine' => 'Avus 1.4 TFSI S tronic',
                'email' => 'test@mail.com',
                'address' => '3 rue des poneys 75015 PARIS',
            ],
            'offer' => [
                'startDate' => (new DateTime('now'))->add(new DateInterval('P3D')),
                'endDate' => $endDate,
            ],
        ];

        $form = $this
            ->getMockBuilder(OfferSecondhandCarTermsType::class)
            ->disableOriginalConstructor()
            ->setMethods(['submit', 'isValid', 'getData'])
            ->getMock();

        $form->method('submit');
        $form->method('isValid')->will($this->returnValue(true));
        $form->method('getData')->will($this->returnValue([
            'modelName' => $data['terms']['modelName'],
            'engine' => $data['terms']['engine'],
            'email' => $data['terms']['email'],
            'address' => $data['terms']['address'],
            'endDate' => strftime('%d %B %Y', strtotime($endDate->format('y-m-d'))),
        ]));

        $res = $this->service->generateNewTerms($form, $data, $this->subtype);

        $this->assertEquals(
            'Offre jusqu\'au '.strftime(
                "%d %B %Y",
                strtotime($endDate->format("y-m-d"))
            ).' pour un modèle Audi A5 Sportback Avus 1.4 TFSI S tronic. 
            Contact par mail : test@mail.com ou par courrier 3 rue des poneys 75015 PARIS',
            $res
        );
    }

    public function testGenerateNewCarTermsOk()
    {
        $this->type->setCategory('NEWCAR');
        $this->subtype->setTerms(
            'Offre du #startDate# au #endDate# pour une #rangeName# #modelName# #engine# #options#
            pour un maximum de #maximumKm# km. 
            Offre pour #monthNumber# mois avec un premier paiement de #advancePayment#€ puis
            #monthRentalNumber# paiements de #monthly#€. Prix en date du #priceDate#.
            Consommation : #mgpMin# - #mgpMax# et emmission : #co2EmissionMin# - #co2EmissionMax#.
            Offre proposé par #partner#.'
        );

        $startDate = (new DateTime('now'))->add(new DateInterval('P3D'));
        $endDate = (new DateTime('now'))->add(new DateInterval('P30D'));

        $data = [
            'terms' => [
                'modelName' => 'Audi A5 Sportback',
                'engine' => 'Avus 1.4 TFSI S tronic',
                'monthNumber' => '30',
                'advancePayment' => '3000,50',
                'monthRentalNumber' => '29',
                'monthly' => '300',
                'priceDate' => '2017-01-01',
                'options' => 'klaxon personnalisé',
                'rangeName' => 'A5',
                'mgpMin' => '3.2',
                'mgpMax' => '8.5',
                'co2EmissionMin' => '3.5',
                'co2EmissionMax' => '5.99',
                'maximumKm' => '50000',
                'partner' => 'Concession PARIS',
            ],
            'offer' => [
                'startDate' => $startDate,
                'endDate' => $endDate,
            ],
        ];

        $form = $this
            ->getMockBuilder(OfferNewCarTermsType::class)
            ->disableOriginalConstructor()
            ->setMethods(['submit', 'isValid', 'getData'])
            ->getMock();

        $form->method('submit');
        $form->method('isValid')->will($this->returnValue(true));
        $form->method('getData')->will($this->returnValue([
            'modelName' => $data['terms']['modelName'],
            'engine' => $data['terms']['engine'],
            'monthNumber' => $data['terms']['monthNumber'],
            'advancePayment' => '3 000,50',
            'monthRentalNumber' => $data['terms']['monthRentalNumber'],
            'monthly' => $data['terms']['monthly'],
            'priceDate' => strftime('%d %B %Y', strtotime('2017-01-01')),
            'options' => $data['terms']['options'],
            'rangeName' => $data['terms']['rangeName'],
            'mgpMin' => '3,20',
            'mgpMax' => '8,50',
            'co2EmissionMin' => '3,50',
            'co2EmissionMax' => '5,99',
            'maximumKm' => '50 000',
            'partner' => $data['terms']['partner'],
            'endDate' => strftime('%d %B %Y', strtotime($endDate->format('y-m-d'))),
            'startDate' => strftime('%d %B %Y', strtotime($startDate->format('y-m-d'))),
        ]));

        $res = $this->service->generateNewTerms($form, $data, $this->subtype);

        $this->assertEquals(
            'Offre du '.strftime(
                "%d %B %Y",
                strtotime($startDate->format("y-m-d"))
            ).' au '.strftime(
                "%d %B %Y",
                strtotime($endDate->format("y-m-d"))
            ).' pour une A5 Audi A5 Sportback Avus 1.4 TFSI S tronic klaxon personnalisé
            pour un maximum de 50 000 km. 
            Offre pour 30 mois avec un premier paiement de 3 000,50€ puis
            29 paiements de 300€. Prix en date du '.strftime(
                "%d %B %Y",
                strtotime('2017-01-01')
            ).'.
            Consommation : 3,20 - 8,50 et emmission : 3,50 - 5,99.
            Offre proposé par Concession PARIS.',
            $res
        );
    }

    public function testUpdateTermsOk()
    {
        $this->type->setCategory('NEWCAR');

        $offer = new OfferSale($this->subtype);
        $offer->setTerms(
            'Offre du 08 Avril 2019 au 15 June 2019 pour une A5 Audi A5 Sportback'
        );
        $offer->setEndDate('2019-06-15');

        $res = $this->service->generateUpdatedTerms($offer, '2019-06-17');

        $this->assertEquals(
            'Offre du 08 Avril 2019 au 17 June 2019 pour une A5 Audi A5 Sportback',
            $res
        );
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGenerateTermsKo()
    {
        $this->type->setCategory('AFTERSALE');
        $this->subtype->setTerms('Offre jusqu\'au #endDate#, et jusqu\'à #km# km.');

        $endDate = (new DateTime('now'))->add(new DateInterval('P30D'));

        $data = [
            'terms' => [],
            'offer' => [
                'startDate' => (new DateTime('now'))->add(new DateInterval('P3D')),
                'endDate' => $endDate,
            ],
        ];

        $form = $this
            ->getMockBuilder(OfferAftersaleTermsType::class)
            ->disableOriginalConstructor()
            ->setMethods(['submit', 'isValid', 'getData'])
            ->getMock();

        $form->method('submit');
        $form->method('isValid')->will($this->returnValue(false));

        $this->service->generateNewTerms($form, $data, $this->subtype);
    }
}
