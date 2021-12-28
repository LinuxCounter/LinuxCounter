<?php

namespace Syw\Front\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Mail
 *
 * @category Entity
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 *
 * @ORM\Entity(repositoryClass="Syw\Front\MainBundle\Repository\MailRepository")
 * @ORM\Table(name="mail")
 */
class Mail
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
     * @ORM\OneToOne(targetEntity="User", inversedBy="mailpref", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="user", referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_allowed", type="integer", options={"default" = 1})
     */
    private $newsletterAllowed;

    /**
     * @var integer
     *
     * @ORM\Column(name="admin_allowed", type="integer", options={"default" = 1})
     */
    private $adminAllowed;

    /**
     * @var integer
     *
     * @ORM\Column(name="other_users_allowed", type="integer", options={"default" = 1})
     */
    private $otherUsersAllowed;

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
     * Set user
     *
     * @param \Syw\Front\MainBundle\Entity\User $user
     * @return Mail
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
     * Set newsletterAllowed
     *
     * @param integer $newsletterAllowed
     * @return Mail
     */
    public function setNewsletterAllowed($newsletterAllowed)
    {
        $this->newsletterAllowed = $newsletterAllowed;

        return $this;
    }

    /**
     * Get newsletterAllowed
     *
     * @return integer
     */
    public function getNewsletterAllowed()
    {
        return $this->newsletterAllowed;
    }

    /**
     * Set adminAllowed
     *
     * @param integer $adminAllowed
     * @return Mail
     */
    public function setAdminAllowed($adminAllowed)
    {
        $this->adminAllowed = $adminAllowed;

        return $this;
    }

    /**
     * Get adminAllowed
     *
     * @return integer
     */
    public function getAdminAllowed()
    {
        return $this->adminAllowed;
    }

    /**
     * Set otherUsersAllowed
     *
     * @param integer $otherUsersAllowed
     * @return Mail
     */
    public function setOtherUsersAllowed($otherUsersAllowed)
    {
        $this->otherUsersAllowed = $otherUsersAllowed;

        return $this;
    }

    /**
     * Get otherUsersAllowed
     *
     * @return integer
     */
    public function getOtherUsersAllowed()
    {
        return $this->otherUsersAllowed;
    }

    /**
     * Set modifiedAt
     *
     * @param \DateTime $modifiedAt
     * @return Mail
     */
    public function setModifiedAt(\DateTime $modifiedAt)
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
