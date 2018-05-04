<?php

namespace OfferBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * @ORM\Column(name="myaudi_user_id", type="integer")
     * @Groups({"rest"})
     */
    private $myaudiUserId;

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
     * Set myaudiUserId
     *
     * @param integer $myaudiUserId
     *
     * @return OfferAftersaleMyaudiUser
     */
    public function setMyaudiUserId($myaudiUserId)
    {
        $this->myaudiUserId = $myaudiUserId;

        return $this;
    }

    /**
     * Get myaudiUserId
     *
     * @return int
     */
    public function getMyaudiUserId()
    {
        return $this->myaudiUserId;
    }
}

