<?php

namespace Syw\Front\ToolBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Syw\Front\MainBundle\Util\XmlToArrayParser;

class DefaultController extends BaseController
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $metatitle = $this->get('translator')->trans('Linux Commands Reference', array(), 'syw_front_toolbox_default_index');
        $title[0] = $metatitle;
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }
        $stats = array();
        $stats['guess'] = $this->getGuessStats();
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('Get an overview and description of the most used Linux commands in this Linux Commands Reference', array(), 'syw_front_toolbox_default_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
            'stats' => $stats
        );
        return array_merge($return1, $return2);
    }
}
