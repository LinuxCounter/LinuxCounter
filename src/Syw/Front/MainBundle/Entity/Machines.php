<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Machines
 *
 * @ORM\Table(name="machines", indexes={@ORM\Index(name="user", columns={"user"}), @ORM\Index(name="country", columns={"country"}), @ORM\Index(name="cpu", columns={"cpu"}), @ORM\Index(name="distribution", columns={"distribution"}), @ORM\Index(name="architecture", columns={"architecture"}), @ORM\Index(name="kernel", columns={"kernel"}), @ORM\Index(name="class", columns={"class"}), @ORM\Index(name="purpose", columns={"purpose"}), @ORM\Index(name="updatekey", columns={"updatekey"}), @ORM\Index(name="created_at", columns={"created_at"}), @ORM\Index(name="online", columns={"online"}), @ORM\Index(name="user_online", columns={"user", "online"}), @ORM\Index(name="user_key", columns={"user", "updatekey"})})
 * @ORM\Entity
 */
class Machines
{
    /**
     * @var string
     *
     * @ORM\Column(name="updatekey", type="string", length=48, nullable=true)
     */
    private $updateKey;

    /**
     * @var string
     *
     * @ORM\Column(name="hostname", type="string", length=128, nullable=true)
     */
    private $hostname;

    /**
     * @var integer
     *
     * @ORM\Column(name="cores", type="integer", nullable=true)
     */
    private $cores;

    /**
     * @var string
     *
     * @ORM\Column(name="flags", type="string", length=255, nullable=true)
     */
    private $flags;

    /**
     * @var integer
     *
     * @ORM\Column(name="accounts", type="integer", nullable=true)
     */
    private $accounts;

    /**
     * @var integer
     *
     * @ORM\Column(name="diskspace", type="bigint", nullable=true)
     */
    private $diskspace;

    /**
     * @var integer
     *
     * @ORM\Column(name="diskspace_free", type="bigint", nullable=true)
     */
    private $diskspaceFree;

    /**
     * @var integer
     *
     * @ORM\Column(name="memory", type="bigint", nullable=true)
     */
    private $memory;

    /**
     * @var integer
     *
     * @ORM\Column(name="memory_free", type="bigint", nullable=true)
     */
    private $memoryFree;

    /**
     * @var integer
     *
     * @ORM\Column(name="swap", type="bigint", nullable=true)
     */
    private $swap;

    /**
     * @var integer
     *
     * @ORM\Column(name="swap_free", type="bigint", nullable=true)
     */
    private $swapFree;

    /**
     * @var string
     *
     * @ORM\Column(name="distversion", type="string", length=24, nullable=true)
     */
    private $distversion;

    /**
     * @var string
     *
     * @ORM\Column(name="mailer", type="string", length=24, nullable=true)
     */
    private $mailer;

    /**
     * @var string
     *
     * @ORM\Column(name="network", type="string", length=24, nullable=true)
     */
    private $network;

    /**
     * @var boolean
     *
     * @ORM\Column(name="online", type="boolean", nullable=true)
     */
    private $online;

    /**
     * @var integer
     *
     * @ORM\Column(name="uptime", type="integer", nullable=true)
     */
    private $uptime;

    /**
     * @var string
     *
     * @ORM\Column(name="loadavg", type="string", length=48, nullable=true)
     */
    private $loadavg;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_at", type="datetime", nullable=true)
     */
    private $modifiedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Syw\Front\MainBundle\Entity\Distributions
     *
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\Distributions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="distribution", referencedColumnName="id")
     * })
     */
    private $distribution;

    /**
     * @var \Syw\Front\MainBundle\Entity\FosUser
     *
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false)
     * })
     */
    private $user;

    /**
     * @var \Syw\Front\MainBundle\Entity\Kernels
     *
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\Kernels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="kernel", referencedColumnName="id")
     * })
     */
    private $kernel;

    /**
     * @var \Syw\Front\MainBundle\Entity\Cpus
     *
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\Cpus")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cpu", referencedColumnName="id")
     * })
     */
    private $cpu;

    /**
     * @var \Syw\Front\MainBundle\Entity\Countries
     *
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\Countries")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country", referencedColumnName="id")
     * })
     */
    private $country;

    /**
     * @var \Syw\Front\MainBundle\Entity\Architectures
     *
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\Architectures")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="architecture", referencedColumnName="id")
     * })
     */
    private $architecture;

    /**
     * @var \Syw\Front\MainBundle\Entity\Classes
     *
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\Classes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="class", referencedColumnName="id")
     * })
     */
    private $class;

    /**
     * @var \Syw\Front\MainBundle\Entity\Purposes
     *
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\Purposes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="purpose", referencedColumnName="id")
     * })
     */
    private $purpose;



    /**
     * Set updateKey
     *
     * @param string $updateKey
     * @return Machines
     */
    public function setUpdateKey($updateKey)
    {
        $this->updateKey = $updateKey;

        return $this;
    }

    /**
     * Get updateKey
     *
     * @return string
     */
    public function getUpdateKey()
    {
        return $this->updateKey;
    }

    /**
     * Set hostname
     *
     * @param string $hostname
     * @return Machines
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;

        return $this;
    }

    /**
     * Get hostname
     *
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * Set cores
     *
     * @param integer $cores
     * @return Machines
     */
    public function setCores($cores)
    {
        $this->cores = $cores;

        return $this;
    }

    /**
     * Get cores
     *
     * @return integer
     */
    public function getCores()
    {
        return $this->cores;
    }

    /**
     * Set flags
     *
     * @param string $flags
     * @return Machines
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Get flags
     *
     * @return string
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Set accounts
     *
     * @param integer $accounts
     * @return Machines
     */
    public function setAccounts($accounts)
    {
        $this->accounts = $accounts;

        return $this;
    }

    /**
     * Get accounts
     *
     * @return integer
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Set diskspace
     *
     * @param integer $diskspace
     * @return Machines
     */
    public function setDiskspace($diskspace)
    {
        $this->diskspace = $diskspace;

        return $this;
    }

    /**
     * Get diskspace
     *
     * @return integer
     */
    public function getDiskspace()
    {
        return $this->diskspace;
    }

    /**
     * Set diskspaceFree
     *
     * @param integer $diskspaceFree
     * @return Machines
     */
    public function setDiskspaceFree($diskspaceFree)
    {
        $this->diskspaceFree = $diskspaceFree;

        return $this;
    }

    /**
     * Get diskspaceFree
     *
     * @return integer
     */
    public function getDiskspaceFree()
    {
        return $this->diskspaceFree;
    }

    /**
     * Set memory
     *
     * @param integer $memory
     * @return Machines
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;

        return $this;
    }

    /**
     * Get memory
     *
     * @return integer
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Set memoryFree
     *
     * @param integer $memoryFree
     * @return Machines
     */
    public function setMemoryFree($memoryFree)
    {
        $this->memoryFree = $memoryFree;

        return $this;
    }

    /**
     * Get memoryFree
     *
     * @return integer
     */
    public function getMemoryFree()
    {
        return $this->memoryFree;
    }

    /**
     * Set swap
     *
     * @param integer $swap
     * @return Machines
     */
    public function setSwap($swap)
    {
        $this->swap = $swap;

        return $this;
    }

    /**
     * Get swap
     *
     * @return integer
     */
    public function getSwap()
    {
        return $this->swap;
    }

    /**
     * Set swapFree
     *
     * @param integer $swapFree
     * @return Machines
     */
    public function setSwapFree($swapFree)
    {
        $this->swapFree = $swapFree;

        return $this;
    }

    /**
     * Get swapFree
     *
     * @return integer
     */
    public function getSwapFree()
    {
        return $this->swapFree;
    }

    /**
     * Set distversion
     *
     * @param string $distversion
     * @return Machines
     */
    public function setDistversion($distversion)
    {
        $this->distversion = $distversion;

        return $this;
    }

    /**
     * Get distversion
     *
     * @return string
     */
    public function getDistversion()
    {
        return $this->distversion;
    }

    /**
     * Set mailer
     *
     * @param string $mailer
     * @return Machines
     */
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;

        return $this;
    }

    /**
     * Get mailer
     *
     * @return string
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * Set network
     *
     * @param string $network
     * @return Machines
     */
    public function setNetwork($network)
    {
        $this->network = $network;

        return $this;
    }

    /**
     * Get network
     *
     * @return string
     */
    public function getNetwork()
    {
        return $this->network;
    }

    /**
     * Set online
     *
     * @param boolean $online
     * @return Machines
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return boolean
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set uptime
     *
     * @param integer $uptime
     * @return Machines
     */
    public function setUptime($uptime)
    {
        $this->uptime = $uptime;

        return $this;
    }

    /**
     * Get uptime
     *
     * @return integer
     */
    public function getUptime()
    {
        return $this->uptime;
    }

    /**
     * Set loadavg
     *
     * @param string $loadavg
     * @return Machines
     */
    public function setLoadAvg($loadavg)
    {
        $this->loadavg = $loadavg;

        return $this;
    }

    /**
     * Get loadavg
     *
     * @return string
     */
    public function getLoadAvg()
    {
        return $this->loadavg;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Machines
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     * @return Machines
     */
    public function setModifiedAt($modifiedAt)
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    /**
     * Get modifiedAt
     *
     * @return \DateTime
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
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
     * Set id
     *
     * @return Machines
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set distribution
     *
     * @param \Syw\Front\MainBundle\Entity\Distributions $distribution
     * @return Machines
     */
    public function setDistribution(\Syw\Front\MainBundle\Entity\Distributions $distribution = null)
    {
        $this->distribution = $distribution;

        return $this;
    }

    /**
     * Get distribution
     *
     * @return \Syw\Front\MainBundle\Entity\Distributions
     */
    public function getDistribution()
    {
        return $this->distribution;
    }

    /**
     * Set user
     *
     * @param \Syw\Front\MainBundle\Entity\User $user
     * @return Machines
     */
    public function setUser(\Syw\Front\MainBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Syw\Front\MainBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set kernel
     *
     * @param \Syw\Front\MainBundle\Entity\Kernels $kernel
     * @return Machines
     */
    public function setKernel(\Syw\Front\MainBundle\Entity\Kernels $kernel = null)
    {
        $this->kernel = $kernel;

        return $this;
    }

    /**
     * Get kernel
     *
     * @return \Syw\Front\MainBundle\Entity\Kernels
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Set cpu
     *
     * @param \Syw\Front\MainBundle\Entity\Cpus $cpu
     * @return Machines
     */
    public function setCpu(\Syw\Front\MainBundle\Entity\Cpus $cpu = null)
    {
        $this->cpu = $cpu;

        return $this;
    }

    /**
     * Get cpu
     *
     * @return \Syw\Front\MainBundle\Entity\Cpus
     */
    public function getCpu()
    {
        return $this->cpu;
    }

    /**
     * Set country
     *
     * @param \Syw\Front\MainBundle\Entity\Countries $country
     * @return Machines
     */
    public function setCountry(\Syw\Front\MainBundle\Entity\Countries $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Syw\Front\MainBundle\Entity\Countries
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set architecture
     *
     * @param \Syw\Front\MainBundle\Entity\Architectures $architecture
     * @return Machines
     */
    public function setArchitecture(\Syw\Front\MainBundle\Entity\Architectures $architecture = null)
    {
        $this->architecture = $architecture;

        return $this;
    }

    /**
     * Get architecture
     *
     * @return \Syw\Front\MainBundle\Entity\Architectures
     */
    public function getArchitecture()
    {
        return $this->architecture;
    }

    /**
     * Set class
     *
     * @param \Syw\Front\MainBundle\Entity\Classes $class
     * @return Machines
     */
    public function setClass(\Syw\Front\MainBundle\Entity\Classes $class = null)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get class
     *
     * @return \Syw\Front\MainBundle\Entity\Classes
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set purpose
     *
     * @param \Syw\Front\MainBundle\Entity\Purposes $purpose
     * @return Machines
     */
    public function setPurpose(\Syw\Front\MainBundle\Entity\Purposes $purpose = null)
    {
        $this->purpose = $purpose;

        return $this;
    }

    /**
     * Get purpose
     *
     * @return \Syw\Front\MainBundle\Entity\Purposes
     */
    public function getPurpose()
    {
        return $this->purpose;
    }
}
