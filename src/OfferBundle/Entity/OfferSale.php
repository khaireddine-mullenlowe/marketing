<?php

namespace OfferBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * OfferSale
 *
 * @ORM\Table(name="offer_sale")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferSaleRepository")
 */
class OfferSale extends BaseOffer
{
    const SECONDNHAND = 'SECONDHANDCAR';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"rest"})
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
     *
     * @Groups({"rest"})
     */
    protected $subtype;

    /**
     * @var float
     *
     * In Front, a div block (to display prices) is movable and we have to keep
     * the position to display this div block in myaudi at the same position.
     * The X position is the top left corner abscissa position
     *
     * @ORM\Column(name="x_position", type="float")
     *
     * @Groups({"rest"})
     */
    protected $xPosition;

    /**
     * @var float
     *
     * In Front, a div block (to display prices) is movable and we have to keep
     * the position to display this div block in myaudi at the same position.
     * The Y position is the top left corner ordinate position
     *
     * @ORM\Column(name="y_position", type="float")
     *
     * @Groups({"rest"})
     */
    protected $yPosition;

    /**
     * @var float
     *
     * @ORM\Column(name="monthly", type="float")
     *
     * @Groups({"rest"})
     */
    protected $monthly;

    /**
     * @var int
     *
     * The model of the vehicle
     *
     * @ORM\Column(name="model_id", type="integer")
     *
     * @Groups({"rest"})
     */
    protected $modelId;

    /**
     * @var OfferSecondhandCarTermsProperty
     *
     * @ORM\OneToOne(
     *     targetEntity="OfferSecondhandCarTermsProperty",
     *     mappedBy="offer",
     *     cascade={"persist", "remove"}
     * )
     *
     * @Groups({"rest"})
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
     *
     * @Groups({"rest"})
     */
    protected $termsPropertyNewCar;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="OfferSaleMyaudiUser",
     *     mappedBy="offer",
     *     cascade={"persist", "remove"}
     * )
     */
    protected $myaudiUsers;

    /**
     * OfferSale constructor.
     * @param OfferSubtype $subtype
     */
    public function __construct(OfferSubtype $subtype)
    {
        parent::__construct();
        $this->subtype = $subtype;
        $this->myaudiUsers = new ArrayCollection();
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
     * Set modelId
     *
     * @param integer $modelId
     *
     * @return OfferSale
     */
    public function setModelId($modelId)
    {
        $this->modelId = $modelId;

        return $this;
    }

    /**
     * Get modelId
     *
     * @return int
     */
    public function getModelId()
    {
        return $this->modelId;
    }

    /**
     * @param OfferNewCarTermsProperty $termsPropertyNewCar
     * @return OfferSale
     */
    public function setTermsPropertyNewCar(OfferNewCarTermsProperty $termsPropertyNewCar)
    {
        $this->termsPropertyNewCar = $termsPropertyNewCar;

        return $this;
    }

    /**
     * @return OfferNewCarTermsProperty
     */
    public function getTermsPropertyNewCar()
    {
        return $this->termsPropertyNewCar;
    }

    /**
     * @param OfferSecondhandCarTermsProperty $termsPropertySecondhandCar
     * @return OfferSale
     */
    public function setTermsPropertySecondhandCar(OfferSecondhandCarTermsProperty $termsPropertySecondhandCar)
    {
        $this->termsPropertySecondhandCar = $termsPropertySecondhandCar;

        return $this;
    }

    /**
     * @return OfferSecondhandCarTermsProperty
     */
    public function getTermsPropertySecondhandCar()
    {
        return $this->termsPropertySecondhandCar;
    }

    /**
     * @param OfferNewCarTermsProperty|OfferSecondhandCarTermsProperty $termsProperty
     * @return OfferSale
     */
    public function setTermsProperty($termsProperty)
    {
        $category = $this->getSubtype()->getType()->getCategory();
        if ($category === self::SECONDNHAND) {
            $this->setTermsPropertySecondhandCar($termsProperty);
        } else {
            $this->setTermsPropertyNewCar($termsProperty);
        }

        return $this;
    }

    /**
     * @return OfferSecondhandCarTermsProperty|OfferNewCarTermsProperty
     */
    public function getTermsProperty()
    {
        $category = $this->getSubtype()->getType()->getCategory();
        if ($category === self::SECONDNHAND) {
            return $this->getTermsPropertySecondhandCar();
        }

        return $this->getTermsPropertyNewCar();
    }

    /**
     * @param ArrayCollection $myaudiUsers
     *
     * @return OfferAftersale
     */
    public function setMyaudiUsers(ArrayCollection $myaudiUsers)
    {
        $this->myaudiUsers = $myaudiUsers;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMyaudiUsers()
    {
        return $this->myaudiUsers;
    }
}
