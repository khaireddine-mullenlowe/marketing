<?php

namespace MarketingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Score
 *
 * @ORM\Table(name="score")
 * @ORM\Entity(repositoryClass="MarketingBundle\Repository\ScoreRepository")
 */
class Score
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(name="userId", type="integer")
     * @ORM\Id()
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="ccp", type="integer")
     */
    private $ccp;

    /**
     * @var int
     *
     * @ORM\Column(name="pft", type="integer")
     */
    private $pft;

    /**
     * @var int
     *
     * @ORM\Column(name="pu", type="integer")
     */
    private $pu;

    /**
     * @var int
     *
     * @ORM\Column(name="top", type="integer")
     */
    private $top;

    /**
     * @var int
     *
     * @ORM\Column(name="aam1", type="integer")
     */
    private $aam1;

    /**
     * @var int
     *
     * @ORM\Column(name="acc", type="integer")
     */
    private $acc;

    /**
     * @var int
     *
     * @ORM\Column(name="b", type="integer")
     */
    private $b;

    /**
     * @var int
     *
     * @ORM\Column(name="g", type="integer")
     */
    private $g;

    /**
     * @var int
     *
     * @ORM\Column(name="ac", type="integer")
     */
    private $ac;

    /**
     * @var int
     *
     * @ORM\Column(name="pp", type="integer")
     */
    private $pp;

    /**
     * @var int
     *
     * @ORM\Column(name="pf", type="integer")
     */
    private $pf;

    /**
     * @var int
     *
     * @ORM\Column(name="ta", type="integer")
     */
    private $ta;

    /**
     * @var int
     *
     * @ORM\Column(name="pum", type="integer")
     */
    private $pum;

    /**
     * @var int
     *
     * @ORM\Column(name="aam2", type="integer")
     */
    private $aam2;

    /**
     * @var int
     *
     * @ORM\Column(name="ppm", type="integer")
     */
    private $ppm;

    /**
     * @var float
     *
     * @ORM\Column(name="interestAverage", type="float")
     */
    private $interestAverage;

    /**
     * @var float
     *
     * @ORM\Column(name="seriousnessAverage", type="float")
     */
    private $seriousnessAverage;

    /**
     * @var string
     *
     * @ORM\Column(name="contactType", type="string", length=255)
     */
    private $contactType;

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Score
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
     * Set ccp
     *
     * @param integer $ccp
     *
     * @return Score
     */
    public function setCcp($ccp)
    {
        $this->ccp = $ccp;

        return $this;
    }

    /**
     * Get ccp
     *
     * @return int
     */
    public function getCcp()
    {
        return $this->ccp;
    }

    /**
     * Set pft
     *
     * @param integer $pft
     *
     * @return Score
     */
    public function setPft($pft)
    {
        $this->pft = $pft;

        return $this;
    }

    /**
     * Get pft
     *
     * @return int
     */
    public function getPft()
    {
        return $this->pft;
    }

    /**
     * Set pu
     *
     * @param integer $pu
     *
     * @return Score
     */
    public function setPu($pu)
    {
        $this->pu = $pu;

        return $this;
    }

    /**
     * Get pu
     *
     * @return int
     */
    public function getPu()
    {
        return $this->pu;
    }

    /**
     * Set top
     *
     * @param integer $top
     *
     * @return Score
     */
    public function setTop($top)
    {
        $this->top = $top;

        return $this;
    }

    /**
     * Get top
     *
     * @return int
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * Set aam1
     *
     * @param integer $aam1
     *
     * @return Score
     */
    public function setAam1($aam1)
    {
        $this->aam1 = $aam1;

        return $this;
    }

    /**
     * Get aam1
     *
     * @return int
     */
    public function getAam1()
    {
        return $this->aam1;
    }

    /**
     * Set acc
     *
     * @param integer $acc
     *
     * @return Score
     */
    public function setAcc($acc)
    {
        $this->acc = $acc;

        return $this;
    }

    /**
     * Get acc
     *
     * @return int
     */
    public function getAcc()
    {
        return $this->acc;
    }

    /**
     * Set b
     *
     * @param integer $b
     *
     * @return Score
     */
    public function setB($b)
    {
        $this->b = $b;

        return $this;
    }

    /**
     * Get b
     *
     * @return int
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * Set g
     *
     * @param integer $g
     *
     * @return Score
     */
    public function setG($g)
    {
        $this->g = $g;

        return $this;
    }

    /**
     * Get g
     *
     * @return int
     */
    public function getG()
    {
        return $this->g;
    }

    /**
     * Set ac
     *
     * @param integer $ac
     *
     * @return Score
     */
    public function setAc($ac)
    {
        $this->ac = $ac;

        return $this;
    }

    /**
     * Get ac
     *
     * @return int
     */
    public function getAc()
    {
        return $this->ac;
    }

    /**
     * Set pp
     *
     * @param integer $pp
     *
     * @return Score
     */
    public function setPp($pp)
    {
        $this->pp = $pp;

        return $this;
    }

    /**
     * Get pp
     *
     * @return int
     */
    public function getPp()
    {
        return $this->pp;
    }

    /**
     * Set pf
     *
     * @param integer $pf
     *
     * @return Score
     */
    public function setPf($pf)
    {
        $this->pf = $pf;

        return $this;
    }

    /**
     * Get pf
     *
     * @return int
     */
    public function getPf()
    {
        return $this->pf;
    }

    /**
     * Set ta
     *
     * @param integer $ta
     *
     * @return Score
     */
    public function setTa($ta)
    {
        $this->ta = $ta;

        return $this;
    }

    /**
     * Get ta
     *
     * @return int
     */
    public function getTa()
    {
        return $this->ta;
    }

    /**
     * Set pum
     *
     * @param integer $pum
     *
     * @return Score
     */
    public function setPum($pum)
    {
        $this->pum = $pum;

        return $this;
    }

    /**
     * Get pum
     *
     * @return int
     */
    public function getPum()
    {
        return $this->pum;
    }

    /**
     * Set aam2
     *
     * @param integer $aam2
     *
     * @return Score
     */
    public function setAam2($aam2)
    {
        $this->aam2 = $aam2;

        return $this;
    }

    /**
     * Get aam2
     *
     * @return int
     */
    public function getAam2()
    {
        return $this->aam2;
    }

    /**
     * Set ppm
     *
     * @param integer $ppm
     *
     * @return Score
     */
    public function setPpm($ppm)
    {
        $this->ppm = $ppm;

        return $this;
    }

    /**
     * Get ppm
     *
     * @return int
     */
    public function getPpm()
    {
        return $this->ppm;
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
     * Set seriousnessAverage
     *
     * @param float $seriousnessAverage
     *
     * @return Score
     */
    public function setSeriousnessAverage($seriousnessAverage)
    {
        $this->seriousnessAverage = $seriousnessAverage;

        return $this;
    }

    /**
     * Get seriousnessAverage
     *
     * @return float
     */
    public function getSeriousnessAverage()
    {
        return $this->seriousnessAverage;
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
