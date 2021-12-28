<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Languages
 *
 * @ORM\Entity(repositoryClass="Syw\Front\MainBundle\Repository\LanguageRepository")
 * @UniqueEntity(fields="locale", message="Locale already exists.")
 * @ORM\Table(name="languages", indexes={@ORM\Index(name="active", columns={"active"}), @ORM\Index(name="language", columns={"language"}), @ORM\Index(name="search", columns={"active", "language"})}))
 */
class Languages
{
    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=7, nullable=false)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=7, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=128, nullable=false)
     */
    private $language;

    /**
     * @var integer
     *
     * @ORM\Column(name="active", type="integer", length=1, nullable=false)
     */
    private $active;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set locale
     *
     * @param string $locale
     * @return Languages
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return Languages
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Languages
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set active
     *
     * @param integer $active
     * @return Languages
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return integer
     */
    public function getActive()
    {
        return $this->active;
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
