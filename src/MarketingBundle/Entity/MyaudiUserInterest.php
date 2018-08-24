<?php

namespace MarketingBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * MyaudiUserInterest
 *
 * @ORM\Table(name="interest_user")
 * @ORM\Entity()
 * @UniqueEntity(
 *     fields={"myaudiUserId", "interest"},
 *     message="A subscription already exist for this user and interest."
 * )
 */
class MyaudiUserInterest
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
     * @var int
     * @Assert\NotNull
     *
     * @ORM\Column(name="myaudi_user_id", type="integer")
     */
    private $myaudiUserId;

    /**
     * @var string
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(
     *     targetEntity="Interest"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $interest;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="subscription_date", type="datetime")
     */
    private $subscriptionDate;

    /**
     * MyaudiUserInterest constructor.
     */
    public function __construct()
    {
        $this->subscriptionDate = new \DateTime();
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
     * Set myaudiUserId
     *
     * @param integer $myaudiUserId
     *
     * @return MyaudiUserInterest
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

    /**
     * Set interest
     *
     * @param string $interest
     *
     * @return MyaudiUserInterest
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get interest
     *
     * @return string
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Set subscriptionDate
     *
     * @param DateTime $subscriptionDate
     *
     * @return MyaudiUserInterest
     */
    public function setSubscriptionDate($subscriptionDate)
    {
        $this->subscriptionDate = $subscriptionDate;

        return $this;
    }

    /**
     * Get subscriptionDate
     *
     * @return DateTime
     */
    public function getSubscriptionDate()
    {
        return $this->subscriptionDate;
    }
}
