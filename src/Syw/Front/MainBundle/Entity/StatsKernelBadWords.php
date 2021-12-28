<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cpus
 *
 * @ORM\Table(name="stats_kernel_badwords", indexes={@ORM\Index(name="version", columns={"version"})})
 * @ORM\Entity
 */
class StatsKernelBadWords
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="version", type="string", length=24, nullable=false)
     */
    private $version;

    /**
     * @var integer
     *
     * @ORM\Column(name="fuck", type="integer", nullable=false)
     */
    private $fuck;


    /**
     * @var integer
     *
     * @ORM\Column(name="shit", type="integer", nullable=false)
     */
    private $shit;


    /**
     * @var integer
     *
     * @ORM\Column(name="crap", type="integer", nullable=false)
     */
    private $crap;


    /**
     * @var integer
     *
     * @ORM\Column(name="bastard", type="integer", nullable=false)
     */
    private $bastard;


    /**
     * @var integer
     *
     * @ORM\Column(name="piss", type="integer", nullable=false)
     */
    private $piss;


    /**
     * @var integer
     *
     * @ORM\Column(name="fire", type="integer", nullable=false)
     */
    private $fire;


    /**
     * @var integer
     *
     * @ORM\Column(name="asshole", type="integer", nullable=false)
     */
    private $asshole;


    /**
     * Set version
     *
     * @param string $version
     * @return StatsKernelBadWords
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set fuck
     *
     * @param integer $fuck
     * @return StatsKernelBadWords
     */
    public function setFuck($fuck)
    {
        $this->fuck = $fuck;

        return $this;
    }

    /**
     * Get fuck
     *
     * @return integer
     */
    public function getFuck()
    {
        return $this->fuck;
    }

    /**
     * Set shit
     *
     * @param integer $shit
     * @return StatsKernelBadWords
     */
    public function setShit($shit)
    {
        $this->shit = $shit;

        return $this;
    }

    /**
     * Get shit
     *
     * @return integer
     */
    public function getShit()
    {
        return $this->shit;
    }

    /**
     * Set crap
     *
     * @param integer $crap
     * @return StatsKernelBadWords
     */
    public function setCrap($crap)
    {
        $this->crap = $crap;

        return $this;
    }

    /**
     * Get crap
     *
     * @return integer
     */
    public function getCrap()
    {
        return $this->crap;
    }

    /**
     * Set bastard
     *
     * @param integer $bastard
     * @return StatsKernelBadWords
     */
    public function setBastard($bastard)
    {
        $this->bastard = $bastard;

        return $this;
    }

    /**
     * Get bastard
     *
     * @return integer
     */
    public function getBastard()
    {
        return $this->bastard;
    }

    /**
     * Set piss
     *
     * @param integer $piss
     * @return StatsKernelBadWords
     */
    public function setPiss($piss)
    {
        $this->piss = $piss;

        return $this;
    }

    /**
     * Get piss
     *
     * @return integer
     */
    public function getPiss()
    {
        return $this->piss;
    }

    /**
     * Set fire
     *
     * @param integer $fire
     * @return StatsKernelBadWords
     */
    public function setFire($fire)
    {
        $this->fire = $fire;

        return $this;
    }

    /**
     * Get fire
     *
     * @return integer
     */
    public function getFire()
    {
        return $this->fire;
    }

    /**
     * Set asshole
     *
     * @param integer $asshole
     * @return StatsKernelBadWords
     */
    public function setAsshole($asshole)
    {
        $this->asshole = $asshole;

        return $this;
    }

    /**
     * Get asshole
     *
     * @return integer
     */
    public function getAsshole()
    {
        return $this->asshole;
    }
}
