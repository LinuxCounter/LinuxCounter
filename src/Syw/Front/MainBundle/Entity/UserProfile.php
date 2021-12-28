<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class UserProfile
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 * @ORM\Entity(repositoryClass="Syw\Front\MainBundle\Repository\UserProfileRepository")
 * @ORM\Table(name="user_profile")
 */
class UserProfile
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
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Cities", inversedBy="users")
     * @ORM\JoinColumn(name="city", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="Countries", inversedBy="users")
     * @ORM\JoinColumn(name="country", referencedColumnName="id", onDelete="NO ACTION")
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=128, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=128, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="birthday", type="string", length=10, nullable=true)
     */
    private $birthDay = null;

    /**
     * @var string
     *
     * @ORM\Column(name="birthplace", type="string", length=128, nullable=true)
     */
    private $birthPlace;

    /**
     * @var string
     *
     * @ORM\Column(name="homepage", type="string", length=255, nullable=true)
     */
    private $homePage;

    /**
     * @var string
     *
     * @ORM\Column(name="icq", type="string", length=15, nullable=true)
     */
    private $icq;

    /**
     * @var string
     *
     * @ORM\Column(name="skype", type="string", length=128, nullable=true)
     */
    private $skype;

    /**
     * @var string
     *
     * @ORM\Column(name="jabber", type="string", length=255, nullable=true)
     */
    private $jabber;

    /**
     * @var string
     *
     * @ORM\Column(name="msn", type="string", length=255, nullable=true)
     */
    private $msn;

    /**
     * @var string
     *
     * @ORM\Column(name="irc", type="string", length=255, nullable=true)
     */
    private $irc;

    /**
     * @var string
     *
     * @ORM\Column(name="gpg", type="string", length=255, nullable=true)
     */
    private $gpg;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @var string
     *
     * @ORM\Column(name="google", type="string", length=255, nullable=true)
     */
    private $google;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @var string
     *
     * @ORM\Column(name="identica", type="string", length=255, nullable=true)
     */
    private $identica;

    /**
     * @var string
     *
     * @ORM\Column(name="github", type="string", length=255, nullable=true)
     */
    private $github;

    /**
     * @var string
     *
     * @ORM\Column(name="linkedin", type="string", length=255, nullable=true)
     */
    private $linkedin;

    /**
     * @var string
     *
     * @ORM\Column(name="interests", type="string", length=2500, nullable=true)
     */
    private $interests;

    /**
     * @var string
     *
     * @ORM\Column(name="hobbies", type="string", length=2500, nullable=true)
     */
    private $hobbies;

    /**
     * @var string
     *
     * @ORM\Column(name="sincewhen", type="string", length=10, nullable=true)
     */
    private $sincewhen = null;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return UserProfile
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return UserProfile
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set birthDay
     *
     * @param string $birthDay
     * @return UserProfile
     */
    public function setBirthDay($birthDay)
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    /**
     * Get birthDay
     *
     * @return string
     */
    public function getBirthDay()
    {
        return $this->birthDay;
    }

    /**
     * Set birthPlace
     *
     * @param string $birthPlace
     * @return UserProfile
     */
    public function setBirthPlace($birthPlace)
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    /**
     * Get birthPlace
     *
     * @return string
     */
    public function getBirthPlace()
    {
        return $this->birthPlace;
    }

    /**
     * Set homePage
     *
     * @param string $homePage
     * @return UserProfile
     */
    public function setHomePage($homePage)
    {
        $this->homePage = $homePage;

        return $this;
    }

    /**
     * Get homePage
     *
     * @return string
     */
    public function getHomePage()
    {
        return $this->homePage;
    }

    /**
     * Set icq
     *
     * @param string $icq
     * @return UserProfile
     */
    public function setIcq($icq)
    {
        $this->icq = $icq;

        return $this;
    }

    /**
     * Get icq
     *
     * @return string
     */
    public function getIcq()
    {
        return $this->icq;
    }

    /**
     * Set skype
     *
     * @param string $skype
     * @return UserProfile
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;

        return $this;
    }

    /**
     * Get skype
     *
     * @return string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set jabber
     *
     * @param string $jabber
     * @return UserProfile
     */
    public function setJabber($jabber)
    {
        $this->jabber = $jabber;

        return $this;
    }

    /**
     * Get jabber
     *
     * @return string
     */
    public function getJabber()
    {
        return $this->jabber;
    }

    /**
     * Set msn
     *
     * @param string $msn
     * @return UserProfile
     */
    public function setMsn($msn)
    {
        $this->msn = $msn;

        return $this;
    }

    /**
     * Get msn
     *
     * @return string
     */
    public function getMsn()
    {
        return $this->msn;
    }


    /**
     * Set irc
     *
     * @param string $irc
     * @return UserProfile
     */
    public function setIrc($irc)
    {
        $this->irc = $irc;

        return $this;
    }

    /**
     * Get irc
     *
     * @return string
     */
    public function getIrc()
    {
        return $this->irc;
    }


    /**
     * Set gpg
     *
     * @param string $gpg
     * @return UserProfile
     */
    public function setGpg($gpg)
    {
        $this->gpg = $gpg;

        return $this;
    }

    /**
     * Get gpg
     *
     * @return string
     */
    public function getGpg()
    {
        return $this->gpg;
    }

    /**
     * Set facebook
     *
     * @param string $facebook
     * @return UserProfile
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook
     *
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set google
     *
     * @param string $google
     * @return UserProfile
     */
    public function setGoogle($google)
    {
        $this->google = $google;

        return $this;
    }

    /**
     * Get google
     *
     * @return string
     */
    public function getGoogle()
    {
        return $this->google;
    }

    /**
     * Set twitter
     *
     * @param string $twitter
     * @return UserProfile
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set identica
     *
     * @param string $identica
     * @return UserProfile
     */
    public function setIdentica($identica)
    {
        $this->identica = $identica;

        return $this;
    }

    /**
     * Get identica
     *
     * @return string
     */
    public function getIdentica()
    {
        return $this->identica;
    }

    /**
     * Set github
     *
     * @param string $github
     * @return UserProfile
     */
    public function setGithub($github)
    {
        $this->github = $github;

        return $this;
    }

    /**
     * Get github
     *
     * @return string
     */
    public function getGithub()
    {
        return $this->github;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     * @return UserProfile
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Set interests
     *
     * @param string $interests
     * @return UserProfile
     */
    public function setInterests($interests)
    {
        $this->interests = $interests;

        return $this;
    }

    /**
     * Get interests
     *
     * @return string
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * Set hobbies
     *
     * @param string $hobbies
     * @return UserProfile
     */
    public function setHobbies($hobbies)
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    /**
     * Get hobbies
     *
     * @return string
     */
    public function getHobbies()
    {
        return $this->hobbies;
    }


    /**
     * Set sincewhen
     *
     * @param string $sincewhen
     * @return UserProfile
     */
    public function setSinceWhen($sincewhen)
    {
        $this->sincewhen = $sincewhen;

        return $this;
    }

    /**
     * Get sincewhen
     *
     * @return string
     */
    public function getSinceWhen()
    {
        return $this->sincewhen;
    }

    /**
     * Set user
     *
     * @param \Syw\Front\MainBundle\Entity\User $user
     * @return UserProfile
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
     * Set city
     *
     * @param \Syw\Front\MainBundle\Entity\Cities $city
     * @return UserProfile
     */
    public function setCity(\Syw\Front\MainBundle\Entity\Cities $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Syw\Front\MainBundle\Entity\Cities
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param \Syw\Front\MainBundle\Entity\Countries $country
     * @return UserProfile
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
}
