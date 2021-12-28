<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Privacy
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="privacy")
 */
class Privacy
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
     * @ORM\Column(name="secret_profile", type="boolean", length=1, nullable=false, options={"default"="0"})
     */
    private $secretProfile = 0;

    /**
     * @ORM\Column(name="secret_counterdata", type="boolean", length=1, nullable=false, options={"default"="0"})
     */
    private $secretCounterData = 0;

    /**
     * @ORM\Column(name="secret_machines", type="boolean", length=1, nullable=false, options={"default"="0"})
     */
    private $secretMachines = 0;

    /**
     * @ORM\Column(name="secret_contactinfo", type="boolean", length=1, nullable=false, options={"default"="1"})
     */
    private $secretContactInfo = 1;

    /**
     * @ORM\Column(name="secret_socialinfo", type="boolean", length=1, nullable=false, options={"default"="1"})
     */
    private $secretSocialInfo = 1;

    /**
     * @ORM\Column(name="show_realname", type="boolean", length=1, nullable=false, options={"default"="0"})
     */
    private $showRealName = 0;

    /**
     * @ORM\Column(name="show_email", type="boolean", length=1, nullable=false, options={"default"="0"})
     */
    private $showEmail = 0;

    /**
     * @ORM\Column(name="show_location", type="boolean", length=1, nullable=false, options={"default"="0"})
     */
    private $showLocation = 0;

    /**
     * @ORM\Column(name="show_hostnames", type="boolean", length=1, nullable=false, options={"default"="0"})
     */
    private $showHostnames = 0;

    /**
     * @ORM\Column(name="show_kernel", type="boolean", length=1, nullable=false, options={"default"="1"})
     */
    private $showKernel = 1;

    /**
     * @ORM\Column(name="show_distribution", type="boolean", length=1, nullable=false, options={"default"="1"})
     */
    private $showDistribution = 1;

    /**
     * @ORM\Column(name="show_versions", type="boolean", length=1, nullable=false, options={"default"="0"})
     */
    private $showVersions = 0;

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
     * Set secretProfile
     *
     * @param integer $secretProfile
     * @return Privacy
     */
    public function setSecretProfile($secretProfile)
    {
        $this->secretProfile = $secretProfile;

        return $this;
    }

    /**
     * Get secretProfile
     *
     * @return integer
     */
    public function getSecretProfile()
    {
        return $this->secretProfile;
    }

    /**
     * Set secretCounterData
     *
     * @param integer $secretCounterData
     * @return Privacy
     */
    public function setSecretCounterData($secretCounterData)
    {
        $this->secretCounterData = $secretCounterData;

        return $this;
    }

    /**
     * Get secretCounterData
     *
     * @return integer
     */
    public function getSecretCounterData()
    {
        return $this->secretCounterData;
    }

    /**
     * Set secretMachines
     *
     * @param integer $secretMachines
     * @return Privacy
     */
    public function setSecretMachines($secretMachines)
    {
        $this->secretMachines = $secretMachines;

        return $this;
    }

    /**
     * Get secretMachines
     *
     * @return integer
     */
    public function getSecretMachines()
    {
        return $this->secretMachines;
    }

    /**
     * Set secretContactInfo
     *
     * @param integer $secretContactInfo
     * @return Privacy
     */
    public function setSecretContactInfo($secretContactInfo)
    {
        $this->secretContactInfo = $secretContactInfo;

        return $this;
    }

    /**
     * Get secretContactInfo
     *
     * @return integer
     */
    public function getSecretContactInfo()
    {
        return $this->secretContactInfo;
    }

    /**
     * Set secretSocialInfo
     *
     * @param integer $secretSocialInfo
     * @return Privacy
     */
    public function setSecretSocialInfo($secretSocialInfo)
    {
        $this->secretSocialInfo = $secretSocialInfo;

        return $this;
    }

    /**
     * Get secretSocialInfo
     *
     * @return integer
     */
    public function getSecretSocialInfo()
    {
        return $this->secretSocialInfo;
    }

    /**
     * Set showRealName
     *
     * @param integer $showRealName
     * @return Privacy
     */
    public function setShowRealName($showRealName)
    {
        $this->showRealName = $showRealName;

        return $this;
    }

    /**
     * Get showRealName
     *
     * @return integer
     */
    public function getShowRealName()
    {
        return $this->showRealName;
    }

    /**
     * Set showEmail
     *
     * @param integer $showEmail
     * @return Privacy
     */
    public function setShowEmail($showEmail)
    {
        $this->showEmail = $showEmail;

        return $this;
    }

    /**
     * Get showEmail
     *
     * @return integer
     */
    public function getShowEmail()
    {
        return $this->showEmail;
    }

    /**
     * Set showLocation
     *
     * @param integer $showLocation
     * @return Privacy
     */
    public function setShowLocation($showLocation)
    {
        $this->showLocation = $showLocation;

        return $this;
    }

    /**
     * Get showLocation
     *
     * @return integer
     */
    public function getShowLocation()
    {
        return $this->showLocation;
    }

    /**
     * Set showHostnames
     *
     * @param integer $showHostnames
     * @return Privacy
     */
    public function setShowHostnames($showHostnames)
    {
        $this->showHostnames = $showHostnames;

        return $this;
    }

    /**
     * Get showHostnames
     *
     * @return integer
     */
    public function getShowHostnames()
    {
        return $this->showHostnames;
    }

    /**
     * Set showKernel
     *
     * @param integer $showKernel
     * @return Privacy
     */
    public function setShowKernel($showKernel)
    {
        $this->showKernel = $showKernel;

        return $this;
    }

    /**
     * Get showKernel
     *
     * @return integer
     */
    public function getShowKernel()
    {
        return $this->showKernel;
    }

    /**
     * Set showDistribution
     *
     * @param integer $showDistribution
     * @return Privacy
     */
    public function setShowDistribution($showDistribution)
    {
        $this->showDistribution = $showDistribution;

        return $this;
    }

    /**
     * Get showDistribution
     *
     * @return integer
     */
    public function getShowDistribution()
    {
        return $this->showDistribution;
    }

    /**
     * Set showVersions
     *
     * @param integer $showVersions
     * @return Privacy
     */
    public function setShowVersions($showVersions)
    {
        $this->showVersions = $showVersions;

        return $this;
    }

    /**
     * Get showVersions
     *
     * @return integer
     */
    public function getShowVersions()
    {
        return $this->showVersions;
    }

    /**
     * Set user
     *
     * @param \Syw\Front\MainBundle\Entity\User $user
     * @return Privacy
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
}
