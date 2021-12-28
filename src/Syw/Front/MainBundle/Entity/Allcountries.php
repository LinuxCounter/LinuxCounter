<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Allcountries
 *
 * @ORM\Table(name="allCountries", indexes={@ORM\Index(name="name", columns={"name"}), @ORM\Index(name="feature_code", columns={"feature_code"}), @ORM\Index(name="country_code", columns={"country_code"})})
 * @ORM\Entity
 */
class Allcountries
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="asciiname", type="string", length=255, nullable=true)
     */
    private $asciiname;

    /**
     * @var string
     *
     * @ORM\Column(name="alternatenames", type="string", length=255, nullable=true)
     */
    private $alternatenames;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=11, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=11, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="feature_class", type="string", length=3, nullable=true)
     */
    private $featureClass;

    /**
     * @var string
     *
     * @ORM\Column(name="feature_code", type="string", length=5, nullable=true)
     */
    private $featureCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=5, nullable=false)
     */
    private $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="cc2", type="string", length=5, nullable=true)
     */
    private $cc2;

    /**
     * @var string
     *
     * @ORM\Column(name="admin1_code", type="string", length=5, nullable=true)
     */
    private $admin1Code;

    /**
     * @var string
     *
     * @ORM\Column(name="admin2_code", type="string", length=5, nullable=true)
     */
    private $admin2Code;

    /**
     * @var string
     *
     * @ORM\Column(name="admin3_code", type="string", length=5, nullable=true)
     */
    private $admin3Code;

    /**
     * @var string
     *
     * @ORM\Column(name="admin4_code", type="string", length=5, nullable=true)
     */
    private $admin4Code;

    /**
     * @var integer
     *
     * @ORM\Column(name="population", type="integer", nullable=true)
     */
    private $population;

    /**
     * @var integer
     *
     * @ORM\Column(name="elevation", type="integer", nullable=true)
     */
    private $elevation;

    /**
     * @var string
     *
     * @ORM\Column(name="dem", type="string", length=10, nullable=true)
     */
    private $dem;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=40, nullable=true)
     */
    private $timezone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modification_date", type="datetime", nullable=true)
     */
    private $modificationDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="geonameid", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $geonameid;



    /**
     * Set name
     *
     * @param string $name
     * @return Allcountries
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
     * Set asciiname
     *
     * @param string $asciiname
     * @return Allcountries
     */
    public function setAsciiname($asciiname)
    {
        $this->asciiname = $asciiname;

        return $this;
    }

    /**
     * Get asciiname
     *
     * @return string
     */
    public function getAsciiname()
    {
        return $this->asciiname;
    }

    /**
     * Set alternatenames
     *
     * @param string $alternatenames
     * @return Allcountries
     */
    public function setAlternatenames($alternatenames)
    {
        $this->alternatenames = $alternatenames;

        return $this;
    }

    /**
     * Get alternatenames
     *
     * @return string
     */
    public function getAlternatenames()
    {
        return $this->alternatenames;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Allcountries
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Allcountries
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set featureClass
     *
     * @param string $featureClass
     * @return Allcountries
     */
    public function setFeatureClass($featureClass)
    {
        $this->featureClass = $featureClass;

        return $this;
    }

    /**
     * Get featureClass
     *
     * @return string
     */
    public function getFeatureClass()
    {
        return $this->featureClass;
    }

    /**
     * Set featureCode
     *
     * @param string $featureCode
     * @return Allcountries
     */
    public function setFeatureCode($featureCode)
    {
        $this->featureCode = $featureCode;

        return $this;
    }

    /**
     * Get featureCode
     *
     * @return string
     */
    public function getFeatureCode()
    {
        return $this->featureCode;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     * @return Allcountries
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set cc2
     *
     * @param string $cc2
     * @return Allcountries
     */
    public function setCc2($cc2)
    {
        $this->cc2 = $cc2;

        return $this;
    }

    /**
     * Get cc2
     *
     * @return string
     */
    public function getCc2()
    {
        return $this->cc2;
    }

    /**
     * Set admin1Code
     *
     * @param string $admin1Code
     * @return Allcountries
     */
    public function setAdmin1Code($admin1Code)
    {
        $this->admin1Code = $admin1Code;

        return $this;
    }

    /**
     * Get admin1Code
     *
     * @return string
     */
    public function getAdmin1Code()
    {
        return $this->admin1Code;
    }

    /**
     * Set admin2Code
     *
     * @param string $admin2Code
     * @return Allcountries
     */
    public function setAdmin2Code($admin2Code)
    {
        $this->admin2Code = $admin2Code;

        return $this;
    }

    /**
     * Get admin2Code
     *
     * @return string
     */
    public function getAdmin2Code()
    {
        return $this->admin2Code;
    }

    /**
     * Set admin3Code
     *
     * @param string $admin3Code
     * @return Allcountries
     */
    public function setAdmin3Code($admin3Code)
    {
        $this->admin3Code = $admin3Code;

        return $this;
    }

    /**
     * Get admin3Code
     *
     * @return string
     */
    public function getAdmin3Code()
    {
        return $this->admin3Code;
    }

    /**
     * Set admin4Code
     *
     * @param string $admin4Code
     * @return Allcountries
     */
    public function setAdmin4Code($admin4Code)
    {
        $this->admin4Code = $admin4Code;

        return $this;
    }

    /**
     * Get admin4Code
     *
     * @return string
     */
    public function getAdmin4Code()
    {
        return $this->admin4Code;
    }

    /**
     * Set population
     *
     * @param integer $population
     * @return Allcountries
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
     * Set elevation
     *
     * @param integer $elevation
     * @return Allcountries
     */
    public function setElevation($elevation)
    {
        $this->elevation = $elevation;

        return $this;
    }

    /**
     * Get elevation
     *
     * @return integer
     */
    public function getElevation()
    {
        return $this->elevation;
    }

    /**
     * Set dem
     *
     * @param string $dem
     * @return Allcountries
     */
    public function setDem($dem)
    {
        $this->dem = $dem;

        return $this;
    }

    /**
     * Get dem
     *
     * @return string
     */
    public function getDem()
    {
        return $this->dem;
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     * @return Allcountries
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set modificationDate
     *
     * @param \DateTime $modificationDate
     * @return Allcountries
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * Get modificationDate
     *
     * @return \DateTime
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Get geonameid
     *
     * @return integer
     */
    public function getGeonameid()
    {
        return $this->geonameid;
    }
}
