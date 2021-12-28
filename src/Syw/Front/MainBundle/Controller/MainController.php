<?php

namespace Syw\Front\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Syw\Front\MainBundle\Form\Type\ContactType;
use Syw\Front\MainBundle\Form\Type\TranslationFormType;
use Asm\TranslationLoaderBundle\Entity\Translation;

class MainController extends BaseController
{
    /**
     * @Route("/")
     * @Method("GET")
     *
     * @Template()
     */
    public function indexAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }
        $stats = array();
        $metatitle = "";
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('The Linuxcounter generates statistics around Linux and its users and machines. This includes uptimes, load average, distributions, kernels and much more', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
            'stats' => $stats
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/contact")
     *
     * @Template()
     */
    public function contactAction(Request $request)
    {
        
        // Disabled! 
        return false;
        exit;
        
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $form = $this->createForm(new ContactType());

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($form->get('subject')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo($this->container->getParameter('admin_email'))
                    ->setBody(
                        $this->renderView(
                            'SywFrontMainBundle:Mail:contact.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'name' => $form->get('name')->getData(),
                                'message' => $form->get('message')->getData()
                            )
                        )
                    );

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');

                return $this->redirect($this->generateUrl('syw_front_main_main_contact'));
            }
        }

        $metatitle = $this->get('translator')->trans('Contact us by sending us an email', array(), 'syw_front_main_main_contact');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'form' => $form->createView(),
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('Contact us in case of problems, issues, feature requests or if you just want to talk about the project.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/about")
     * @Method("GET")
     *
     * @Template()
     */
    public function aboutAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('About the Linux Counter', array(), 'syw_front_main_main_about');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('All abut the Linux Counter Project. Read here what the Counter is and does.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/press")
     * @Method("GET")
     *
     * @Template()
     */
    public function pressAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('The Linux Counter in the press', array(), 'syw_front_main_main_press');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('Find here articles in the international press about the Linux Counter', array(), 'syw_front_main_main_press'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/download")
     * @Method("GET")
     *
     * @Template()
     */
    public function downloadAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('Get the free update script for your machine', array(), 'syw_front_main_main_downloads');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('Our Machine Update script is completly free and open source. Download and install it to always be up to date.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/imprint")
     * @Method("GET")
     *
     * @Template()
     */
    public function impressumAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('Our Imprint', array(), 'syw_front_main_main_impressum');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('Se who is behind the Linux Counter and who has developed all this cool stuff.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/faq")
     * @Method("GET")
     *
     * @Template()
     */
    public function faqAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('FAQ - Frequently Asked Questions', array(), 'syw_front_main_main_faq');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('If you have any questions or problems regarding the Linux Counter, this page should be your first try.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/donations")
     * @Method("GET")
     *
     * @Template()
     */
    public function donationsAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('Donations to the Project', array(), 'syw_front_main_main_donations');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('See here how you can help us by supporting the Linux Counter with your donations.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/sponsor")
     * @Method("GET")
     *
     * @Template()
     */
    public function sponsorAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('The Linux Counter is fully sponsored by FIRST COLO', array(), 'syw_front_main_main_sponsor');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('FIRST COLO is our sponsor of the hardware and the bandwidth. See here, what FIRST COLO is and does.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/privacypolicy")
     * @Method("GET")
     *
     * @Template()
     */
    public function privacypolicyAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('This is our Privacy Policy', array(), 'syw_front_main_main_privacypolicy');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('This is all about your privacy. Read here, how we handle your private data.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/tos")
     * @Method("GET")
     *
     * @Template()
     */
    public function tosAction()
    {
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $metatitle = $this->get('translator')->trans('Terms of Service of the Linux Counter', array(), 'syw_front_main_main_tos');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('If you are unsure what you are allowed to do on the Linux Counter, read this.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }

    /**
     * @Route("/lang")
     * @Method("POST")
     */
    public function langAction(Request $request)
    {
        $locale = $request->request->get('language');
        $userManager = $this->get('fos_user.user_manager');

        $user = $this->getUser();
        if (true === isset($user) && true === is_object($user)) {
            $user->setLocale($locale);
            $userManager->updateUser($user);
        } else {
            $user = null;
        }

        $this->get('session')->set('_locale', $locale);

        return $this->redirect($this->generateUrl('syw_front_main_main_index', array('_locale' => $locale)));

        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'languages' => $languages,
            'user' => $user,
        );
        return array_merge($return1, $return2);
    }
}
