<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferAftersaleMyaudiUser
 *
 * @ORM\Table(name="offer_aftersale_myaudi_user")
 * @ORM\Entity(repositoryClass="OfferBundle\Repository\OfferAftersaleMyaudiUserRepository")
 */
class OfferAftersaleMyaudiUser
{
    /**
     * @var OfferAftersale
     *
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\Id
     * @ORM\ManyToOne(
     *     targetEntity="OfferAftersale",
     *     inversedBy="myaudiUsers",
     *     fetch="EAGER"
     * )
     */
    private $offer;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="myaudiUser", type="integer")
     */
    private $myaudiUser;

    /**
     * Set offer
     *
     * @param OfferAftersale $offer
     *
     * @return OfferAftersaleMyaudiUser
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return OfferAftersale
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
     * @return OfferAftersaleMyaudiUser
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

