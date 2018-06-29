<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * ObjectiveMarketingUser
 *
 * @ORM\Table(name="objective_marketing_user")
 * @ORM\Entity()
 */
class ObjectiveMarketingUser
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     */
    protected $userId;

    /**
     * @var string
     *
     * @ORM\ManyToOne(
     *     targetEntity="ObjectiveMarketing"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\Id
     */
    protected $objectiveMarketing;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_unsubscribe", type="boolean")
     */
    protected $isUnsubscribe;

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return ObjectiveMarketingUser
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set objectiveMarketing
     *
     * @param string $objectiveMarketing
     *
     * @return ObjectiveMarketingUser
     */
    public function setObjectiveMarketing($objectiveMarketing)
    {
        $this->objectiveMarketing = $objectiveMarketing;

        return $this;
    }

    /**
     * Get objectiveMarketing
     *
     * @return string
     */
    public function getObjectiveMarketing()
    {
        return $this->objectiveMarketing;
    }

    /**
     * Set isUnsubscribe
     *
     * @param boolean $isUnsubscribe
     *
     * @return ObjectiveMarketingUser
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

