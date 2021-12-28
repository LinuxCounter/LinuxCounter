<?php

namespace Syw\Front\ManagerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Asm\TranslationLoaderBundle\Entity\Translation;
use Syw\Front\MainBundle\Entity\Cities;
use Syw\Front\ManagerBundle\Form\CityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class CorrectController extends BaseController
{
    /**
     * @Route("/manager/correct/city/{cityid}")
     * @Security("has_role('ROLE_MANAGER')")
     *
     * @Template()
     */
    public function correctcityAction(Request $request, $cityid)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }
        $em = $this->getDoctrine()->getManager();
        $city = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Cities')
            ->findOneBy(array('id' => $cityid));
        $form = $this->createForm(new CityType(), $city);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $editCity = $form->getData();
            $em->flush();
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->set('success', 'City data saved!');
            return $this->redirectToRoute('syw_front_main_stats_cities', array('id' => $editCity->getId()));
        }
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        $metatitle = $this->get('translator')->trans('Manager Console', array(), 'syw_front_manager');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'form' => $form->createView(),
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $metatitle,
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }
}
