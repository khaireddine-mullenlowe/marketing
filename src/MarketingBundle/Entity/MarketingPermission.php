<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class MarketingPermission
 * @package MarketingBundle\Entity
 *
 * @ORM\Table(name="marketing_permission")
 * @ORM\Entity()
 */
class MarketingPermission
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="myaudi_user_id", type="integer")
     * @ORM\Id
     */
    protected $myaudiUserId;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $dataUseAgreement;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $email;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $phone;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $postal;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @return int
     */
    public function getMyaudiUserId()
    {
        return $this->myaudiUserId;
    }

    /**
     * @param int $myaudiUserId
     *
     * @return MarketingPermission
     */
    public function setMyaudiUserId($myaudiUserId): MarketingPermission
    {
        $this->myaudiUserId = $myaudiUserId;

        return $this;
    }

    /**
     * @return int
     */
    public function getDataUseAgreement()
    {
        return $this->dataUseAgreement;
    }

    /**
     * @param int $dataUseAgreement
     *
     * @return MarketingPermission
     */
    public function setDataUseAgreement($dataUseAgreement): MarketingPermission
    {
        $this->dataUseAgreement = $dataUseAgreement;

        return $this;
    }

    /**
     * @return int
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param int $email
     *
     * @return MarketingPermission
     */
    public function setEmail($email): MarketingPermission
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param int $phone
     *
     * @return MarketingPermission
     */
    public function setPhone($phone): MarketingPermission
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return int
     */
    public function getPostal()
    {
        return $this->postal;
    }

    /**
     * @param int $postal
     *
     * @return MarketingPermission
     */
    public function setPostal($postal): MarketingPermission
    {
        $this->postal = $postal;

        return $this;
    }
}
