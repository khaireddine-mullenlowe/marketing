<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * MyaudiUserMarketingObjective
 *
 * @ORM\Table(name="myaudi_user_marketing_objective")
 * @ORM\Entity()
 */
class MyaudiUserMarketingObjective
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="myaudi_user_id", type="integer")
     * @ORM\Id
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
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\Id
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

