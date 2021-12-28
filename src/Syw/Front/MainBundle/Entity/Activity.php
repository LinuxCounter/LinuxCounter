<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Activity
 *
 * @category Entity
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 *
 * @ORM\Table(name="activity", indexes={@ORM\Index(name="user", columns={"user"}), @ORM\Index(name="isbot", columns={"isbot"}), @ORM\Index(name="createdat", columns={"createdat"}), @ORM\Index(name="getolusers", columns={"createdat", "isbot"})})
 * @ORM\Entity
 */
class Activity
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Syw\Front\MainBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=true, onDelete="NO ACTION")
     * })
     */
    private $user = null;

    /**
     * @ORM\Column(name="route", type="string", length=128, nullable=false)
     */
    private $route;

    /**
     * @ORM\Column(name="ipaddress", type="string", length=20, nullable=false)
     */
    private $ipaddress;

    /**
     * @ORM\Column(name="useragent", type="string", length=255, nullable=false)
     */
    private $useragent;

    /**
     * @ORM\Column(name="isbot", type="integer", length=1, nullable=false)
     */
    private $isbot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdat", type="datetime", nullable=false)
     */
    private $createdat;

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
     * Set user
     *
     * @param \Syw\Front\MainBundle\Entity\User $user
     * @return Activity
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
     * Set route
     *
     * @param string $route
     * @return Activity
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set ipaddress
     *
     * @param string $ipaddress
     * @return Activity
     */
    public function setIpAddress($ipaddress)
    {
        $this->ipaddress = $ipaddress;

        return $this;
    }

    /**
     * Get ipaddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipaddress;
    }

    /**
     * Set useragent
     *
     * @param string $useragent
     * @return Activity
     */
    public function setUserAgent($useragent)
    {
        $this->useragent = $useragent;

        return $this;
    }

    /**
     * Get useragent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->useragent;
    }

    /**
     * Set isbot
     *
     * @param integer $isbot
     * @return Activity
     */
    public function setIsBot($isbot)
    {
        $this->isbot = $isbot;

        return $this;
    }

    /**
     * Get isbot
     *
     * @return integer
     */
    public function getIsBot()
    {
        return $this->isbot;
    }

    /**
     * Set createdat
     *
     * @param \DateTime $createdat
     * @return Activity
     */
    public function setCreatedAt(\DateTime $createdat)
    {
        $this->createdat = $createdat;

        return $this;
    }

    /**
     * Get createdat
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdat;
    }
}
