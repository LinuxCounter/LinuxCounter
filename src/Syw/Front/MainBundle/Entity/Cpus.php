<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Index;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Cpus
 *
 * @ORM\Table(name="cpus", indexes={@ORM\Index(name="name", columns={"name"}), @ORM\Index(name="hertz", columns={"hertz"}), @ORM\Index(name="machinesnum", columns={"machinesnum"})})
 * @ORM\Entity
 */
class Cpus
{
    /**
     * @ORM\OneToMany(targetEntity="Syw\Front\MainBundle\Entity\Machines", mappedBy="cpu")
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
     * @var integer
     *
     * @ORM\Column(name="hertz", type="integer", nullable=false)
     */
    private $hertz;

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
     * @return Cpus
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
     * Set hertz
     *
     * @param integer $hertz
     * @return Cpus
     */
    public function setHertz($hertz)
    {
        $this->hertz = $hertz;

        return $this;
    }

    /**
     * Get hertz
     *
     * @return integer
     */
    public function getHertz()
    {
        return $this->hertz;
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
