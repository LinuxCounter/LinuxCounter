<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cpus
 *
 * @ORM\Table(name="stats_kernel_goodwords", indexes={@ORM\Index(name="version", columns={"version"})})
 * @ORM\Entity
 */
class StatsKernelGoodWords
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
     * @ORM\Column(name="love", type="integer", nullable=false)
     */
    private $love;


    /**
     * @var integer
     *
     * @ORM\Column(name="good", type="integer", nullable=false)
     */
    private $good;


    /**
     * @var integer
     *
     * @ORM\Column(name="nice", type="integer", nullable=false)
     */
    private $nice;


    /**
     * @var integer
     *
     * @ORM\Column(name="sweet", type="integer", nullable=false)
     */
    private $sweet;


    /**
     * @var integer
     *
     * @ORM\Column(name="kiss", type="integer", nullable=false)
     */
    private $kiss;

    /**
     * Set version
     *
     * @param string $version
     * @return StatsKernelGoodWords
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
     * Set love
     *
     * @param integer $love
     * @return StatsKernelGoodWords
     */
    public function setLove($love)
    {
        $this->love = $love;

        return $this;
    }

    /**
     * Get love
     *
     * @return integer
     */
    public function getLove()
    {
        return $this->love;
    }

    /**
     * Set good
     *
     * @param integer $good
     * @return StatsKernelGoodWords
     */
    public function setGood($good)
    {
        $this->good = $good;

        return $this;
    }

    /**
     * Get good
     *
     * @return integer
     */
    public function getGood()
    {
        return $this->good;
    }

    /**
     * Set nice
     *
     * @param integer $nice
     * @return StatsKernelGoodWords
     */
    public function setNice($nice)
    {
        $this->nice = $nice;

        return $this;
    }

    /**
     * Get nice
     *
     * @return integer
     */
    public function getNice()
    {
        return $this->nice;
    }

    /**
     * Set sweet
     *
     * @param integer $sweet
     * @return StatsKernelGoodWords
     */
    public function setSweet($sweet)
    {
        $this->sweet = $sweet;

        return $this;
    }

    /**
     * Get sweet
     *
     * @return integer
     */
    public function getSweet()
    {
        return $this->sweet;
    }

    /**
     * Set kiss
     *
     * @param integer $kiss
     * @return StatsKernelGoodWords
     */
    public function setKiss($kiss)
    {
        $this->kiss = $kiss;

        return $this;
    }

    /**
     * Get kiss
     *
     * @return integer
     */
    public function getKiss()
    {
        return $this->kiss;
    }
}
