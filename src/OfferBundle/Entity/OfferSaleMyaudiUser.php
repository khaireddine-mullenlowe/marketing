<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferSaleMyaudiUser
 *
 * @ORM\Table(name="offer_sale_myaudi_user")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferSaleMyaudiUserRepository")
 */
class OfferSaleMyaudiUser
{
    /**
     * @var OfferSale
     *
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\Id
     * @ORM\ManyToOne(
     *     targetEntity="OfferSale",
     *     inversedBy="myaudiUsers",
     *     fetch="EAGER"
     * )
     */
    private $offer;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="MyaudiUser", type="integer")
     */
    private $myaudiUser;

    /**
     * Set offer
     *
     * @param OfferSale $offer
     *
     * @return OfferSaleMyaudiUser
     */
    public function setOffer($offer)
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
     * Set myaudiUser
     *
     * @param integer $myaudiUser
     *
     * @return OfferSaleMyaudiUser
     */
    public function setMyaudiUser($myaudiUser)
    {
        $this->myaudiUser = $myaudiUser;

        return $this;
    }

    /**
     * Get myaudiUser
     *
     * @return int
     */
    public function getMyaudiUser()
    {
        return $this->myaudiUser;
    }
}

