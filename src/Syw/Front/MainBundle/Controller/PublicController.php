<?php

namespace Syw\Front\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class PublicController
 *
 * @category Controller
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class PublicController extends BaseController
{
    /**
     * @Route("/user/{counternumber}")
     * @Method("GET")
     *
     * @Template()
     */
    public function profileAction($counternumber)
    {
        $thisuser =  $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:User')
            ->findOneBy(array('id' => $counternumber));
        $locale = $thisuser->getLocale();
        $thisuserProfile = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:UserProfile')
            ->findOneBy(array('user' => $thisuser));
        $language = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $locale));
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        $thisprivacy = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Privacy')
            ->findOneBy(array('user' => $thisuser));
        $thismachines = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Machines')
            ->findBy(array('user' => $thisuser));
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('Public user profile page', array(), 'syw_front_main_public_profile');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $host = $this->getHost();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'language' => $language->getLanguage(),
            'host' => $host,
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('This is the public user profile page of the Linux Counter. See here more information about this specific user.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'thisuser' => $thisuser,
            'thisuserprofile' => $thisuserProfile,
            'thisprivacy' => $thisprivacy,
            'thismachines' => $thismachines,
            'languages' => $languages,
            'user' => $user
        );
        return $this->render('SywFrontMainBundle:Public:profile.html.twig', array_merge($return1, $return2));
    }

    /**
     * @Route("/machine/{machinenumber}")
     * @Method("GET")
     *
     * @Template()
     */
    public function machineAction($machinenumber)
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        $thismachine = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Machines')
            ->findOneBy(array('id' => $machinenumber));
        $thisuser = $thismachine->getUser();
        $thisuserprofile = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:UserProfile')
            ->findOneBy(array('user' => $thisuser));
        $locale = $thisuser->getLocale();
        $language = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $locale));
        $thisprivacy = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Privacy')
            ->findOneBy(array('user' => $thisuser));
        $bday = $thisuserprofile->getBirthDay();

        $seconds = $thismachine->getUptime();
        $uptime = $this->formatSeconds($seconds);

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }
        $metatitle = $this->get('translator')->trans('Public machine profile page', array(), 'syw_front_main_public_machine');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $host = $this->getHost();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'birthday' => $bday,
            'accountInfo' => $this->getAccountInfo(),
            'host' => $host,
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('This is the public machine page of the Linux Counter. See here more information about this specific machine.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'thisuser' => $thisuser,
            'thisprivacy' => $thisprivacy,
            'thismachine' => $thismachine,
            'thisuserprofile' => $thisuserprofile,
            'uptime' => $uptime,
            'language' => $language,
            'languages' => $languages,
            'user' => $user
        );
        return $this->render('SywFrontMainBundle:Public:machine.html.twig', array_merge($return1, $return2));
    }
}
