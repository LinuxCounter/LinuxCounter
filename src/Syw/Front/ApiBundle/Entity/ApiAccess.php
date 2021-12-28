<?php

namespace Syw\Front\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class ApiAccess
 *
 * @category Entity
 * @package  SywFrontApiBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 *
 * @ORM\Table(name="api_access")
 * @ORM\Entity
 */
class ApiAccess
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
     * @ORM\ManyToOne(targetEntity="Syw\Front\MainBundle\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $user;

    /**
     * @ORM\Column(name="apikey", type="string", length=48, nullable=false)
     */
    private $apikey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_access", type="datetime", nullable=true)
     */
    private $lastaccess;

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
     * @return ApiAccess
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
     * Set apikey
     *
     * @param string $apikey
     * @return ApiAccess
     */
    public function setApiKey($apikey)
    {
        $this->apikey = $apikey;

        return $this;
    }

    /**
     * Get apikey
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apikey;
    }

    /**
     * Set lastaccess
     *
     * @param \DateTime $lastaccess
     * @return ApiAccess
     */
    public function setLastAccess(\DateTime $lastaccess)
    {
        $this->lastaccess = $lastaccess;

        return $this;
    }

    /**
     * Get lastaccess
     *
     * @return \DateTime
     */
    public function getLastAccess()
    {
        return $this->lastaccess;
    }
}
