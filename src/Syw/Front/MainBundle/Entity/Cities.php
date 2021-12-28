<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Cities
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 * @ORM\Entity(repositoryClass="Syw\Front\MainBundle\Repository\CitiesRepository")
 * @ORM\Table(name="cities", indexes={@Index(name="name", columns={"name"}), @Index(name="searchcity", columns={"iso_country_code", "name"}), @Index(name="searchkoords", columns={"latitude", "longitude"}), @Index(name="usernum", columns={"usernum"})})
 */
class Cities
{
    /**
     * @ORM\OneToMany(targetEntity="UserProfile", mappedBy="city")
     */
    protected $users;
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="iso_country_code", type="string", length=4, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min=2,max=2)
     */
    private $isoCountryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="fips_country_code", type="string", length=4, nullable=true)
     */
    private $fipsCountryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=64, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     */
    private $region;

    /**
     * @var integer
     *
     * @ORM\Column(name="population", type="integer", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min=1)
     */
    private $population;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="short_name", type="string", length=48, nullable=true)
     */
    private $shortName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min=2)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="usernum", type="integer", length=11, nullable=true)
     */
    private $usernum;

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
     * Set usernum
     *
     * @param integer $usernum
     * @return Architectures
     */
    public function setUserNum($usernum)
    {
        $this->usernum = $usernum;

        return $this;
    }

    /**
     * Get usernum
     *
     * @return integer
     */
    public function getUserNum()
    {
        return $this->usernum;
    }

    /**
     * Set isoCountryCode
     *
     * @param string $isoCountryCode
     * @return Cities
     */
    public function setIsoCountryCode($isoCountryCode)
    {
        $this->isoCountryCode = $isoCountryCode;

        return $this;
    }

    /**
     * Get isoCountryCode
     *
     * @return string
     */
    public function getIsoCountryCode()
    {
        return $this->isoCountryCode;
    }

    /**
     * Set fipsCountryCode
     *
     * @param string $fipsCountryCode
     * @return Cities
     */
    public function setFipsCountryCode($fipsCountryCode)
    {
        $this->fipsCountryCode = $fipsCountryCode;

        return $this;
    }

    /**
     * Get fipsCountryCode
     *
     * @return string
     */
    public function getFipsCountryCode()
    {
        return $this->fipsCountryCode;
    }

    /**
     * Set region
     *
     * @param string $region
     * @return Cities
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set population
     *
     * @param integer $population
     * @return Cities
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
     * Set latitude
     *
     * @param float $latitude
     * @return Cities
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Cities
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set shortName
     *
     * @param string $shortName
     * @return Cities
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get shortName
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Cities
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
     * Get users
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
