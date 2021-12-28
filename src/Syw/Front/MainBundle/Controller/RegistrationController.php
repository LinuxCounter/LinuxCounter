<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Syw\Front\MainBundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;
use Syw\Front\MainBundle\Entity\UserProfile;

/**
 * Controller managing the registration
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Christophe Coevoet <stof@notk.org>
 */
class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

            $em = $this->getDoctrine()->getManager();
            $userManager->updateUser($user);

            $userProfile = new UserProfile();
            $userProfile->setUser($user);
            $userProfile->setCreatedAt(new \DateTime());
            $em->persist($userProfile);
            $em->flush();

            $mailpref = new \Syw\Front\MainBundle\Entity\Mail();
            $mailpref->setUser($user);
            $mailpref->setNewsletterAllowed(1);
            $mailpref->setAdminAllowed(1);
            $mailpref->setOtherUsersAllowed(1);
            $mailpref->setModifiedAt(new \DateTime());
            $em->persist($mailpref);
            $em->flush();

            $user->setProfile($userProfile);
            $user->setMailPref($mailpref);
            $userManager->updateUser($user);

            $obj = new \Syw\Front\MainBundle\Entity\Privacy();
            $obj->setUser($user);
            $obj->setSecretProfile(0);
            $obj->setSecretCounterData(0);
            $obj->setSecretMachines(0);
            $obj->setSecretContactInfo(0);
            $obj->setSecretSocialInfo(0);
            $obj->setShowRealName(0);
            $obj->setShowEmail(0);
            $obj->setShowLocation(0);
            $obj->setShowHostnames(0);
            $obj->setShowKernel(1);
            $obj->setShowDistribution(1);
            $obj->setShowVersions(0);
            $em->persist($obj);
            $em->flush();

            if (true === isset($_POST['fos_user_registration_form']['newsletter']) && intval($_POST['fos_user_registration_form']['newsletter']) == 1) {
                $email = $user->getEmail();
                unset($user);
                $user = $this->get('doctrine')
                    ->getRepository('SywFrontMainBundle:User')
                    ->findOneBy(array('email' => $email));

                if (false === file_exists('/srv/www.linuxcounter.net/newsletter.email.import.csv')) {
                    $fp = fopen('/srv/www.linuxcounter.net/newsletter.email.import.csv', "a+");
                    fwrite($fp, "CounterID\tEmail\n");
                    fclose($fp);
                }
                $fp = fopen('/srv/www.linuxcounter.net/newsletter.email.import.csv', "a+");
                fwrite($fp, $user->getId() . "\t" . $user->getEmail() . "\n");
                fclose($fp);
            }
            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_registration_confirmed');
                $response = new RedirectResponse($url);
            }

            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        $metatitle = $this->get('translator')->trans('User Account Registration', array(), 'fos_user_registration_register');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('If you want to get counted as a linux user, you must register here for an account in the Linux Counter.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'form' => $form->createView(),
            'languages' => $languages,
            'user' => $user
        );
        return $this->render('FOSUserBundle:Registration:register.html.twig', array_merge($return1, $return2));
    }

    /**
     * Tell the user to check his email provider
     */
    public function checkEmailAction()
    {
        $email = $this->get('session')->get('fos_user_send_confirmation_email/email');
        $this->get('session')->remove('fos_user_send_confirmation_email/email');
        $user = $this->get('fos_user.user_manager')->findUserByEmail($email);
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }

        $metatitle = $this->get('translator')->trans('User Account Registration', array(), 'fos_user_registration_checkEmail');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('If you want to get counted as a linux user, you must register here for an account in the Linux Counter.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'user' => $user,
            'languages' => $languages
        );
        return $this->render('FOSUserBundle:Registration:checkEmail.html.twig', array_merge($return1, $return2));
    }

    /**
     * Receive the confirmation token from user email provider, login the user
     */
    public function confirmAction(Request $request, $token)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user->setConfirmationToken(null);
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRMED, new FilterUserResponseEvent($user, $request, $response));

        return $response;
    }

    /**
     * Tell the user his account is now confirmed
     */
    public function confirmedAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        $metatitle = $this->get('translator')->trans('User Account Registration', array(), 'fos_user_registration_confirmed');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('If you want to get counted as a linux user, you must register here for an account in the Linux Counter.', array(), 'syw_front_main_main_index'),
            'title' => $title,
            'user' => $user,
            'languages' => $languages
        );
        return $this->render('FOSUserBundle:Registration:confirmed.html.twig', array_merge($return1, $return2));
    }
}
