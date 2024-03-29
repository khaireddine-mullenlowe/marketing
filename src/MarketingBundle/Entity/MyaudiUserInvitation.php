<?php


namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MyaudiUserInvitation
 * @package MarketingBundle\Entity
 *
 * @ORM\Table(name="invitation_user")
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\MyaudiUserInvitationRepository")
 * @UniqueEntity(
 *     fields={"myaudiUserId", "invitation"},
 *     message="A subscription already exist for this user and invitation."
 * )
 *
 */
class MyaudiUserInvitation
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
     * @var int
     * @Assert\NotNull
     *
     * @ORM\Column(name="myaudi_user_id", type="integer")
     */
    protected $myaudiUserId;

    /**
     * @var Invitation
     * @Assert\NotNull
     *
     * @ORM\ManyToOne(
     *     targetEntity="Invitation"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $invitation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="subscription_date", type="datetime")
     */
    protected $subscriptionDate;

    public function __construct()
    {
        $this->subscriptionDate = new \DateTime();
    }

    /**
     * Get Id
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
     * @return MyaudiUserInvitation
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
     * Set Invitation
     *
     * @param Invitation $invitation
     * @return MyaudiUserInvitation
     */
    public function setInvitation($invitation)
    {
        $this->invitation = $invitation;

        return $this;
    }

    /**
     * Get Invitation
     *
     * @return Invitation
     */
    public function getInvitation()
    {
        return $this->invitation;
    }

    /**
     * Set subscriptionDate
     *
     * @param \DateTime $subscriptionDate
     *
     * @return MyaudiUserInvitation
     */
    public function setSubscriptionDate($subscriptionDate)
    {
        $this->subscriptionDate = $subscriptionDate;

        return $this;
    }

    /**
     * Get subscriptionDate
     *
     * @return \DateTime
     */
    public function getSubscriptionDate()
    {
        return $this->subscriptionDate;
    }
}
