<?php

namespace Syw\Front\NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BladeTester\LightNewsBundle\Entity\News as BaseNews;
use Eko\FeedBundle\Item\Reader\ItemInterface;

/**
 * Class News
 *
 * @category Entity
 * @package  SywFrontNewsBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 *
 * @ORM\Entity()
 * @ORM\Table(name="news")
 */
class News extends BaseNews implements ItemInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="link", type="text")
     */
    private $link;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param $link
     * @return News
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * This method sets feed item title
     *
     * @param string $title
     *
     * @abstract
     */
    public function setFeedItemTitle($title)
    {
        $this->setTitle($title);
    }

    /**
     * This method sets feed item description (or content)
     *
     * @param string $description
     *
     * @abstract
     */
    public function setFeedItemDescription($description)
    {
        $this->setBody($description);
    }

    /**
     * This method sets feed item URL link
     *
     * @param string $link
     *
     * @abstract
     */
    public function setFeedItemLink($link)
    {
        $this->setLink($link);
    }

    /**
     * This method sets item publication date
     *
     * @param \DateTime $date
     *
     * @abstract
     */
    public function setFeedItemPubDate(\DateTime $date)
    {
        $this->setCreatedAt($date);
    }
}
