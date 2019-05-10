<?php


namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use MarketingBundle\Entity\Base\BaseEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation\Timestampable as Gedmo;

/**
 * Class Invitation
 * @package MarketingBundle\Entity
 *
 * @ORM\Table(name="invitation", indexes={@ORM\Index(name="campaignEventId", columns={"campaign_event_id"})})
 * @ORM\Entity()
 */
class Invitation extends BaseEntity
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
     * @var CampaignEvent
     *
     * @ORM\ManyToOne(
     *     targetEntity="CampaignEvent",
     *     inversedBy="invitations"
     * )
     */
    protected $campaignEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="teaser", type="text", nullable=true)
     */
    protected $teaser;

    /**
     * @var string
     *
     * @ORM\Column(name="mailto", type="text", nullable=true)
     */
    protected $mailto;

    /**
     * @var string
     * @Assert\NotNull
     *
     * @ORM\Column(name="path_desktop", type="string")
     */
    protected $pathDesktop;

    /**
     * @var string
     * @Assert\NotNull
     *
     * @ORM\Column(name="path_tablet", type="string")
     */
    protected $pathTablet;

    /**
     * @var string
     * @Assert\NotNull
     *
     * @ORM\Column(name="path_mobile", type="string")
     */
    protected $pathMobile;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set campaignEvent
     *
     * @param string $campaignEvent
     *
     * @return Invitation
     */
    public function setCampaignEvent($campaignEvent): Invitation
    {
        $this->campaignEvent = $campaignEvent;

        return $this;
    }

    /**
     * Get campaignEvent
     *
     * @return string
     */
    public function getCampaignEvent()
    {
        return $this->campaignEvent;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Invitation
     */
    public function setDescription($description): Invitation
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set teaser
     *
     * @param string $teaser
     *
     * @return Invitation
     */
    public function setTeaser($teaser): Invitation
    {
        $this->teaser = $teaser;

        return $this;
    }

    /**
     * Get teaser
     *
     * @return string
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * Set mailto
     *
     * @param string $mailto
     *
     * @return Invitation
     */
    public function setMailto($mailto): Invitation
    {
        $this->mailto = $mailto;

        return $this;
    }

    /**
     * Get mailto
     *
     * @return string
     */
    public function getMailto()
    {
        return $this->mailto;
    }

    /**
     * Set pathDesktop
     *
     * @param string $pathDesktop
     *
     * @return Invitation
     */
    public function setPathDesktop($pathDesktop): Invitation
    {
        $this->pathDesktop = $pathDesktop;

        return $this;
    }

    /**
     * Get pathDesktop
     *
     * @return string
     */
    public function getPathDesktop()
    {
        return $this->pathDesktop;
    }

    /**
     * Set pathTablet
     *
     * @param string $pathTablet
     *
     * @return Invitation
     */
    public function setPathTablet($pathTablet): Invitation
    {
        $this->pathTablet = $pathTablet;

        return $this;
    }

    /**
     * Get pathTablet
     *
     * @return string
     */
    public function getPathTablet()
    {
        return $this->pathTablet;
    }

    /**
     * Set pathMobile
     *
     * @param string $pathMobile
     *
     * @return Invitation
     */
    public function setPathMobile($pathMobile): Invitation
    {
        $this->pathMobile = $pathMobile;

        return $this;
    }

    /**
     * Get pathMobile
     *
     * @return string
     */
    public function getPathMobile()
    {
        return $this->pathMobile;
    }
}
