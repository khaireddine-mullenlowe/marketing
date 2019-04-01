<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Mullenlowe\CommonBundle\Entity\Traits\IdableEntityTrait;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Score
 *
 * @ORM\Table(name="score")
 * @ORM\Entity()
 */
class Score
{
    use IdableEntityTrait;
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
     */
    protected $myaudiUserId;

    /**
     * @var float
     *
     * @ORM\Column(name="interest_average", type="float")
     */
    protected $interestAverage;

    /**
     * @var float
     *
     * @ORM\Column(name="seriousness", type="float")
     */
    protected $seriousness;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_type", type="string", length=255)
     */
    protected $contactType;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Score
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
     * Set interestAverage
     *
     * @param float $interestAverage
     *
     * @return Score
     */
    public function setInterestAverage($interestAverage)
    {
        $this->interestAverage = $interestAverage;

        return $this;
    }

    /**
     * Get interestAverage
     *
     * @return float
     */
    public function getInterestAverage()
    {
        return $this->interestAverage;
    }

    /**
     * Set seriousness
     *
     * @param float $seriousness
     *
     * @return Score
     */
    public function setSeriousness($seriousness)
    {
        $this->seriousness = $seriousness;

        return $this;
    }

    /**
     * Get seriousness
     *
     * @return float
     */
    public function getSeriousness()
    {
        return $this->seriousness;
    }

    /**
     * Set contactType
     *
     * @param string $contactType
     *
     * @return Score
     */
    public function setContactType($contactType)
    {
        $this->contactType = $contactType;

        return $this;
    }

    /**
     * Get contactType
     *
     * @return string
     */
    public function getContactType()
    {
        return $this->contactType;
    }
}
