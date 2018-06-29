<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * EntryPointUser
 *
 * @ORM\Table(name="entry_point_user")
 * @ORM\Entity()
 */
class EntryPointUser
{
    use TimestampableEntity;

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
     *
     * @ORM\Column(name="userId", type="integer")
     */
    protected $userId;

    /**
     * @var string
     *
     * @ORM\ManyToOne(
     *     targetEntity="EntryPoint"
     * )
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    protected $entryPoint;

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
     * Set userId
     *
     * @param integer $userId
     *
     * @return EntryPointUser
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
     * Set entryPoint
     *
     * @param string $entryPoint
     *
     * @return EntryPointUser
     */
    public function setEntryPoint($entryPoint)
    {
        $this->entryPoint = $entryPoint;

        return $this;
    }

    /**
     * Get entryPoint
     *
     * @return string
     */
    public function getEntryPoint()
    {
        return $this->entryPoint;
    }
}
