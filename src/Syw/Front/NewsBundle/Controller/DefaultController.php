<?php

namespace Syw\Front\NewsBundle\Controller;

use BladeTester\LightNewsBundle\Controller\DefaultController as LightNewsDefaultController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends BaseController
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        // $manager = $this->getNewsManager();
        $news    = $this->get('doctrine')
            ->getRepository('SywFrontNewsBundle:News')
            ->findBy(array(), array('createdAt' => 'DESC'), 10);

        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('News and Announcements');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
            'news' => $news
        );
        return array_merge($return1, $return2);
    }


    /**
     * @Template()
     */
    public function viewAction($id)
    {
        $manager = $this->getNewsManager();
        $news    = $manager->find($id);

        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $body = $news->getBody();
        $body = str_replace("\r", "", $body);
        $body = str_replace("\n\n", "\n", $body);
        $body = str_replace("\n", " ", $body);
        $body = strip_tags($body);
        $metatitle = $news->getTitle();
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $body,
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
            'news' => $news
        );
        return array_merge($return1, $return2);
    }

    private function getNewsManager()
    {
        return $this->get('blade_tester_light_news.news_manager');
    }
}
