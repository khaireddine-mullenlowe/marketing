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
    private $id;

    /**
     * @var OfferSubtype
     *
     * @ORM\ManyToOne(targetEntity="OfferSubtype", inversedBy="offerSales")
     * @ORM\JoinColumn(name="subtype_id", referencedColumnName="id", nullable=false)
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
    private $xPosition;

    /**
     * @var float
     *
     * In Front, a div block (to display prices) is movable and we have to keep
     * the position to display this div block in myaudi at the same position.
     * The Y position is the top left corner ordinate position
     *
     * @ORM\Column(name="yPosition", type="float")
     */
    private $yPosition;

    /**
     * @var float
     *
     * @ORM\Column(name="monthly", type="float")
     */
    private $monthly;

    /**
     * @var int
     *
     * The model of the vehicle
     *
     * @ORM\Column(name="model", type="integer")
     */
    private $model;


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
}

