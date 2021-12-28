<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cpus
 *
 * @ORM\Table(name="stats_kernel_linesofcode", indexes={@ORM\Index(name="version", columns={"version"})})
 * @ORM\Entity
 */
class StatsKernelLinesOfCode
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
     * @ORM\Column(name="num", type="integer", nullable=false)
     */
    private $num;


    /**
     * Set version
     *
     * @param string $version
     * @return StatsKernelLinesOfCode
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
     * Set num
     *
     * @param integer $num
     * @return StatsKernelLinesOfCode
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
