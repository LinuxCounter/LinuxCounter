<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Index;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Distributions
 *
 * @ORM\Table(name="distributions", indexes={@ORM\Index(name="name", columns={"name"}), @ORM\Index(name="machinesnum", columns={"machinesnum"})})
 * @ORM\Entity(repositoryClass="Syw\Front\MainBundle\Repository\DistributionsRepository")
 */
class Distributions
{
    /**
     * @ORM\OneToMany(targetEntity="Syw\Front\MainBundle\Entity\Machines", mappedBy="distribution")
     */
    protected $machines;
    public function __construct()
    {
        $this->machines = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=128, nullable=true)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="machinesnum", type="integer", length=11, nullable=true)
     */
    private $machinesnum;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Get machines
     *
     * @return ArrayCollection
     */
    public function getMachines()
    {
        return $this->machines;
    }

    /**
     * Set machinesnum
     *
     * @param integer $machinesnum
     * @return Architectures
     */
    public function setMachinesNum($machinesnum)
    {
        $this->machinesnum = $machinesnum;

        return $this;
    }

    /**
     * Get machinesnum
     *
     * @return integer
     */
    public function getMachinesNum()
    {
        return $this->machinesnum;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Distributions
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Distributions
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Distributions
     */
    public function setDescription($description)
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
