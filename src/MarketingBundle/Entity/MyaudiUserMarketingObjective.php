<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * MyaudiUserMarketingObjective
 *
 * @ORM\Table(
 *     name="myaudi_user_marketing_objective",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="UNIQ_myaudi_user_marketing_objective",
 *             columns={"myaudi_user_id", "marketing_objective_id"}
 *         )
 *     }
 * )
 * @ORM\Entity()
 */
class MyaudiUserMarketingObjective
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="myaudi_user_id", type="integer")
     *
     * @Assert\NotNull()
     */
    protected $myaudiUserId;

    /**
     * @var string
     *
     * @ORM\ManyToOne(
     *     targetEntity="MarketingObjective"
     * )
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     *
     * @Assert\NotNull()
     */
    protected $marketingObjective;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_unsubscribe", type="boolean")
     *
     * @Assert\NotNull()
     */
    protected $isUnsubscribe = false;

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return MyaudiUserMarketingObjective
     */
    public function setMyaudiUserId($userId)
    {
        $this->myaudiUserId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getMyaudiUserId()
    {
        return $this->myaudiUserId;
    }

    /**
     * Set marketingObjective
     *
     * @param string $marketingObjective
     *
     * @return MyaudiUserMarketingObjective
     */
    public function setMarketingObjective($marketingObjective)
    {
        $this->marketingObjective = $marketingObjective;

        return $this;
    }

    /**
     * Get marketingObjective
     *
     * @return string
     */
    public function getMarketingObjective()
    {
        return $this->marketingObjective;
    }

    /**
     * Set isUnsubscribe
     *
     * @param boolean $isUnsubscribe
     *
     * @return MyaudiUserMarketingObjective
     */
    public function setIsUnsubscribe($isUnsubscribe)
    {
        $this->isUnsubscribe = $isUnsubscribe;

        return $this;
    }

    /**
     * Get isUnsubscribe
     *
     * @return bool
     */
    public function getIsUnsubscribe()
    {
        return $this->isUnsubscribe;
    }
}
