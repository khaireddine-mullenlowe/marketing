<?php

namespace OfferBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * OfferNewCarTermsProperty
 *
 * @ORM\Table(name="offer_new_car_terms_property")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferSecondhandCarTermsPropertyRepository")
 */
class OfferNewCarTermsProperty
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var OfferSale
     *
     * @ORM\OneToOne(
     *     targetEntity="OfferSale",
     *     inversedBy="termsPropertyNewCar"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $offer;

    /**
     * @var int
     *
     * @ORM\Column(name="month_number", type="integer")
     *
     * @Assert\Range(min= 1, max= 999)
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $monthNumber;

    /**
     * @var float
     *
     * @ORM\Column(name="advance_payment", type="float")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $advancePayment;

    /**
     * @var int
     *
     * @ORM\Column(name="month_rental_number", type="integer")
     *
     * @Assert\Range(min= 1, max= 999)
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $monthRentalNumber;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="price_date", type="date")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $priceDate;

    /**
     * @var string
     *
     * @ORM\Column(name="model_name", type="string")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $modelName;

    /**
     * @var string
     *
     * @ORM\Column(name="engine", type="string")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $engine;

    /**
     * @var string
     *
     * @ORM\Column(name="options", type="string")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $options;

    /**
     * @var string
     *
     * @ORM\Column(name="range_name", type="string")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $rangeName;

    /**
     * @var float
     *
     * @ORM\Column(name="mgp_min", type="float")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $mgpMin;

    /**
     * @var float
     *
     * @ORM\Column(name="mgp_max", type="float")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $mgpMax;

    /**
     * @var float
     *
     * @ORM\Column(name="co2emission_min", type="float")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $co2EmissionMin;

    /**
     * @var float
     *
     * @ORM\Column(name="co2emission_max", type="float")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $co2EmissionMax;

    /**
     * @var int
     *
     * @ORM\Column(name="maximum_km", type="integer")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $maximumKm;

    /**
     * @var string
     *
     * @ORM\Column(name="partner_name", type="string")
     *
     * @Groups({"rest", "myaudi"})
     */
    protected $partnerName;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set offer
     *
     * @param OfferSale $offer
     *
     * @return OfferNewCarTermsProperty
     */
    public function setOffer(OfferSale $offer)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return OfferSale
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set monthNumber
     *
     * @param int $monthNumber
     *
     * @return OfferNewCarTermsProperty
     */
    public function setMonthNumber(int $monthNumber)
    {
        $this->monthNumber = $monthNumber;
        $this->monthRentalNumber = $this->monthNumber - 1;

        return $this;
    }

    /**
     * Get monthNumber
     *
     * @return int
     */
    public function getMonthNumber()
    {
        return $this->monthNumber;
    }

    /**
     * Set advancePayment
     *
     * @param float $advancePayment
     *
     * @return OfferNewCarTermsProperty
     */
    public function setAdvancePayment(float $advancePayment)
    {
        $this->advancePayment = $advancePayment;

        return $this;
    }

    /**
     * Get advancePayment
     *
     * @return float
     */
    public function getAdvancePayment()
    {
        return $this->advancePayment;
    }

    /**
     * Get monthRentalNumber
     *
     * @return int
     */
    public function getMonthRentalNumber()
    {
        return $this->monthRentalNumber;
    }

    /**
     * Set priceDate
     *
     * @param string|DateTime $priceDate
     *
     * @return OfferNewCarTermsProperty
     */
    public function setPriceDate($priceDate)
    {
        if ($priceDate instanceof DateTime) {
            $this->priceDate = $priceDate;
        } else {
            $this->priceDate = new DateTime($priceDate);
        }

        return $this;
    }

    /**
     * Get priceDate
     *
     * @return DateTime
     */
    public function getPriceDate()
    {
        return $this->priceDate;
    }

    /**
     * Set modelName
     *
     * @param string $modelName
     *
     * @return OfferNewCarTermsProperty
     */
    public function setModelName(string $modelName)
    {
        $this->modelName = $modelName;

        return $this;
    }

    /**
     * Get modelName
     * @return string
     */
    public function getModelName()
    {
        return $this->modelName;
    }

    /**
     * Set engine
     *
     * @param string $engine
     *
     * @return OfferNewCarTermsProperty
     */
    public function setEngine(string $engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Get engine
     *
     * @return string
     */
    public function getEngine()
    {
        return $this->engine;
    }

    /**
     * Set options
     *
     * @param string $options
     *
     * @return OfferNewCarTermsProperty
     */
    public function setOptions(string $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set rangeName
     *
     * @param string $rangeName
     *
     * @return OfferNewCarTermsProperty
     */
    public function setRangeName(string $rangeName)
    {
        $this->rangeName = $rangeName;

        return $this;
    }

    /**
     * Get rangeName
     *
     * @return string
     */
    public function getRangeName()
    {
        return $this->rangeName;
    }

    /**
     * Set mgpMin
     *
     * @param float $mgpMin
     *
     * @return OfferNewCarTermsProperty
     */
    public function setMgpMin(float $mgpMin)
    {
        $this->mgpMin = $mgpMin;

        return $this;
    }

    /**
     * Get mgpMin
     *
     * @return float
     */
    public function getMgpMin()
    {
        return $this->mgpMin;
    }

    /**
     * Set mgpMax
     *
     * @param float $mgpMax
     *
     * @return OfferNewCarTermsProperty
     */
    public function setMgpMax(float $mgpMax)
    {
        $this->mgpMax = $mgpMax;

        return $this;
    }

    /**
     * Get mgpMax
     *
     * @return float
     */
    public function getMgpMax()
    {
        return $this->mgpMax;
    }

    /**
     * Set co2EmissionMin
     *
     * @param float $co2EmissionMin
     *
     * @return OfferNewCarTermsProperty
     */
    public function setCo2EmissionMin(float $co2EmissionMin)
    {
        $this->co2EmissionMin = $co2EmissionMin;

        return $this;
    }

    /**
     * Get co2EmissionMin
     *
     * @return float
     */
    public function getCo2EmissionMin()
    {
        return $this->co2EmissionMin;
    }

    /**
     * Set co2EmissionMax
     *
     * @param float $co2EmissionMax
     *
     * @return OfferNewCarTermsProperty
     */
    public function setCo2EmissionMax(float $co2EmissionMax)
    {
        $this->co2EmissionMax = $co2EmissionMax;

        return $this;
    }

    /**
     * Get co2EmissionMax
     *
     * @return float
     */
    public function getCo2EmissionMax()
    {
        return $this->co2EmissionMax;
    }

    /**
     * Set maximumKm
     *
     * @param int $maximumKm
     *
     * @return OfferNewCarTermsProperty
     */
    public function setMaximumKm(int $maximumKm)
    {
        $this->maximumKm = $maximumKm;

        return$this;
    }

    /**
     * Get maximumKm
     *
     * @return int
     */
    public function getMaximumKm()
    {
        return $this->maximumKm;
    }

    /**
     * Set partnerName
     *
     * @param string $partnerName
     *
     * @return OfferNewCarTermsProperty
     */
    public function setPartnerName(string $partnerName)
    {
        $this->partnerName = $partnerName;

        return $this;
    }

    /**
     * Get partnerName
     *
     * @return string
     */
    public function getPartnerName()
    {
        return $this->partnerName;
    }
}
