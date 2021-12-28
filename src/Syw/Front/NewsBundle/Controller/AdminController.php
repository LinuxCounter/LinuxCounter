<?php

namespace Syw\Front\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use BladeTester\LightNewsBundle\Controller\AdminController as LightNewsAdminController;
use BladeTester\LightNewsBundle\Form\Type\NewsFormType;
use BladeTester\LightNewsBundle\Entity\News;

class AdminController extends BaseController
{
    /**
     * @Template()
     */
    public function addAction(Request $request)
    {
        $manager = $this->getNewsManager();
        $news    = $manager->build();
        $form    = $this->createForm($this->get('blade_tester_light_news.forms.news'), $news);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $manager->persist($news);
                $translator = $this->get('translator');

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->set('notice', $translator->trans('bladetester_lightnews.system_message.news.add'));

                return $this->redirect($this->generateUrl('news_add'));
            }
        }

        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('About the Linux Counter');
        $title = $metatitle;
        $actuallocale = $this->get('request')->getLocale();
        $transtolanguage = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $actuallocale));
        $transform_array = $this->getTranslateForm();
        return array(
            'formTrans_navi' => $transform_array['navi']->createView(),
            'formTrans_route' => $transform_array['route']->createView(),
            'formTrans_footer' => $transform_array['footer']->createView(),
            'formTrans_others' => $transform_array['others']->createView(),
            'transtolanguage' => $transtolanguage->getLanguage(),
            'metatitle' => $metatitle,
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
            'form' => $form->createView()
        );
    }


    public function removeAction($id)
    {
        $manager = $this->getNewsManager();
        $news    = $manager->find($id);
        $manager->remove($news);
        $translator = $this->get('translator');

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->set('notice', $translator->trans('bladetester_lightnews.system_message.news.remove'));

        return $this->redirect($this->generateUrl('news_homepage'));
    }

    /**
     * @Template()
     */
    public function editAction($id, Request $request)
    {
        $manager = $this->getNewsManager();
        $news    = $manager->find($id);
        $form    = $this->createForm($this->get('blade_tester_light_news.forms.news'), $news);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $manager->update($news);
                $translator = $this->get('translator');

                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->set('notice', $translator->trans('bladetester_lightnews.system_message.news.update'));

                return $this->redirect($this->generateUrl('news_edit', array('id' => $id)));
            }
        }

        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('About the Linux Counter');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $actuallocale = $this->get('request')->getLocale();
        $transtolanguage = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $actuallocale));
        $transform_array = $this->getTranslateForm();
        return array(
            'formTrans_navi' => $transform_array['navi']->createView(),
            'formTrans_route' => $transform_array['route']->createView(),
            'formTrans_footer' => $transform_array['footer']->createView(),
            'formTrans_others' => $transform_array['others']->createView(),
            'transtolanguage' => $transtolanguage->getLanguage(),
            'online' => $online,
            'metatitle' => $metatitle,
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
            'form' => $form->createView(),
            'news' => $news
        );
    }

    /**
     * @Template()
     */
    public function listAction()
    {
        $manager = $this->getNewsManager();
        $news    = $manager->findBy(array(), array('createdAt' => 'DESC'));

        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('About the Linux Counter');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $actuallocale = $this->get('request')->getLocale();
        $transtolanguage = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $actuallocale));
        $transform_array = $this->getTranslateForm();
        return array(
            'formTrans_navi' => $transform_array['navi']->createView(),
            'formTrans_route' => $transform_array['route']->createView(),
            'formTrans_footer' => $transform_array['footer']->createView(),
            'formTrans_others' => $transform_array['others']->createView(),
            'transtolanguage' => $transtolanguage->getLanguage(),
            'online' => $online,
            'metatitle' => $metatitle,
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
            'news' => $news
        );
    }

    private function getNewsManager()
    {
        return $this->get('blade_tester_light_news.news_manager');
    }
}
