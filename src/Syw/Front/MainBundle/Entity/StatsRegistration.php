<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cpus
 *
 * @ORM\Table(name="stats_registration", indexes={@ORM\Index(name="month", columns={"month"})})
 * @ORM\Entity
 */
class StatsRegistration
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(name="month", type="datetime", nullable=false)
     */
    private $month;

    /**
     * @var integer
     *
     * @ORM\Column(name="num", type="integer", nullable=false)
     */
    private $num;


    /**
     * Set month
     *
     * @param \DateTime $month
     * @return StatsRegistration
     */
    public function setMonth(\DateTime $month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get month
     *
     * @return \DateTime
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set num
     *
     * @param integer $num
     * @return StatsRegistration
     */
    public function setNum($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * Get num
     *
     * @return integer
     */
    public function getNum()
    {
        return $this->num;
    }
}
