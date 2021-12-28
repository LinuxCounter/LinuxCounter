<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Index;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Countries
 *
 * @ORM\Table(name="countries", indexes={@ORM\Index(name="code", columns={"code"}), @ORM\Index(name="name", columns={"name"}), @ORM\Index(name="usersnum", columns={"usersnum"}), @ORM\Index(name="machinesnum", columns={"machinesnum"})})
 * @ORM\Entity
 */
class Countries
{
    /**
     * @ORM\OneToMany(targetEntity="Syw\Front\MainBundle\Entity\UserProfile", mappedBy="country")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Syw\Front\MainBundle\Entity\Machines", mappedBy="country")
     */
    protected $machines;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->machines = new ArrayCollection();
    }

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=5, nullable=false)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="population", type="integer", nullable=false)
     */
    private $population;

    /**
     * @var integer
     *
     * @ORM\Column(name="usersnum", type="integer", length=11, nullable=true)
     */
    private $usersnum;

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
     * Set machinesnum
     *
     * @param integer $machinesnum
     * @return Countries
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
     * Set usersnum
     *
     * @param integer $usersnum
     * @return Countries
     */
    public function setUsersNum($usersnum)
    {
        $this->usersnum = $usersnum;

        return $this;
    }

    /**
     * Get usersnum
     *
     * @return integer
     */
    public function getUsersNum()
    {
        return $this->usersnum;
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Countries
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Countries
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
     * Set population
     *
     * @param integer $population
     * @return Countries
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return integer
     */
    public function getPopulation()
    {
        return $this->population;
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

    /**
     * Get users
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Get machines
     *
     * @return ArrayCollection
     */
    public function getMachines()
    {
        return $this->machines;
    }
}
