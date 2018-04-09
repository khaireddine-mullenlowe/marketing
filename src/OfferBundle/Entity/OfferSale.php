<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferSale
 *
 * @ORM\Table(name="offer_sale")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferSaleRepository")
 */
class OfferSale extends BaseOffer
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
     * @var OfferSubtype
     *
     * @ORM\ManyToOne(
     *     targetEntity="OfferSubtype",
     *     inversedBy="offerSales",
     *     fetch="EAGER"
     * )
     * @ORM\JoinColumn(
     *     name="subtype_id",
     *     referencedColumnName="id",
     *     nullable=false
     * )
     */
    protected $subtype;

    /**
     * @var float
     *
     * In Front, a div block (to display prices) is movable and we have to keep
     * the position to display this div block in myaudi at the same position.
     * The X position is the top left corner abscissa position
     *
     * @ORM\Column(name="xPosition", type="float")
     */
    protected $xPosition;

    /**
     * @var float
     *
     * In Front, a div block (to display prices) is movable and we have to keep
     * the position to display this div block in myaudi at the same position.
     * The Y position is the top left corner ordinate position
     *
     * @ORM\Column(name="yPosition", type="float")
     */
    protected $yPosition;

    /**
     * @var float
     *
     * @ORM\Column(name="monthly", type="float")
     */
    protected $monthly;

    /**
     * @var int
     *
     * The model of the vehicle
     *
     * @ORM\Column(name="model", type="integer")
     */
    protected $model;

    /**
     * @var OfferSecondhandCarTermsProperty
     *
     * @ORM\OneToOne(
     *     targetEntity="OfferSecondhandCarTermsProperty",
     *     mappedBy="offer",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $termsPropertySecondhandCar;

    /**
     * @var OfferNewCarTermsProperty
     *
     * @ORM\OneToOne(
     *     targetEntity="OfferNewCarTermsProperty",
     *     mappedBy="offer",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $termsPropertyNewCar;

    /**
     * OfferSale constructor.
     * @param OfferSubtype $subtype
     */
    public function __construct(OfferSubtype $subtype)
    {
        parent::__construct();
        $this->subtype = $subtype;
    }

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
     * Set subtype
     *
     * @param OfferSubtype $subtype
     *
     * @return OfferSale
     */
    public function setSubtype(OfferSubtype $subtype)
    {
        $this->subtype = $subtype;

        return $this;
    }

    /**
     * Get subtype
     *
     * @return OfferSubtype
     */
    public function getSubtype() : OfferSubtype
    {
        return $this->subtype;
    }

    /**
     * Set xPosition
     *
     * @param float $xPosition
     *
     * @return OfferSale
     */
    public function setXPosition($xPosition)
    {
        $this->xPosition = $xPosition;

        return $this;
    }

    /**
     * Get xPosition
     *
     * @return float
     */
    public function getXPosition()
    {
        return $this->xPosition;
    }

    /**
     * Set yPosition
     *
     * @param float $yPosition
     *
     * @return OfferSale
     */
    public function setYPosition($yPosition)
    {
        $this->yPosition = $yPosition;

        return $this;
    }

    /**
     * Get yPosition
     *
     * @return float
     */
    public function getYPosition()
    {
        return $this->yPosition;
    }

    /**
     * Set monthly
     *
     * @param float $monthly
     *
     * @return OfferSale
     */
    public function setMonthly($monthly)
    {
        $this->monthly = $monthly;

        return $this;
    }

    /**
     * Get monthly
     *
     * @return float
     */
    public function getMonthly()
    {
        return $this->monthly;
    }

    /**
     * Set model
     *
     * @param integer $model
     *
     * @return OfferSale
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return int
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param OfferNewCarTermsProperty|OfferSecondhandCarTermsProperty $termsProperty
     * @return OfferSale
     */
    public function setTermsProperty($termsProperty)
    {
        $category = $this->getSubtype()->getType()->getCategory();
        if ($category === 'SECONDHANDCAR') {
            $this->termsPropertySecondhandCar = $termsProperty;
        } else {
            $this->termsPropertyNewCar = $termsProperty;
        }

        return $this;
    }

    /**
     * @return OfferSecondhandCarTermsProperty|OfferNewCarTermsProperty
     */
    public function getTermsProperty()
    {
        $category = $this->getSubtype()->getType()->getCategory();
        if ($category === 'SECONDHANDCAR') {
            return $this->termsPropertySecondhandCar;
        }

        return $this->termsPropertyNewCar;
    }
}
