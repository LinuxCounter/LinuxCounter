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
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Syw\Front\MainBundle\Entity\User;
use Syw\Front\MainBundle\Entity\UserProfile;
use Syw\Front\MainBundle\Entity\Cities;
use Syw\Front\MainBundle\Form\Type\UserPrivacyFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller managing the user privacy
 *
 * @category Controller
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class PrivacyController extends BaseController
{
    /**
     * @Route("/privacy/edit")
     *
     * @Template()
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        if (false === is_object($user) || false === $user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $locale = $user->getLocale();
        $userProfile = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:UserProfile')
            ->findOneBy(array('user' => $user));
        $userPrivacy = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Privacy')
            ->findOneBy(array('user' => $user));
        $language = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $locale));
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if (false === is_object($userProfile)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        if (false === is_object($userPrivacy)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->createForm(
            new UserPrivacyFormType(
                $userPrivacy
            ),
            $userPrivacy
        );

        $form->handleRequest($request);

        // if ($request->getMethod() == 'POST') {
        if ($form->isValid()) {
            $formData = $request->request->all();
            $em = $this->getDoctrine()->getManager();

            $em->persist($userPrivacy);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->set('success', 'User privacy settings saved!');

            return $this->redirectToRoute('fos_user_profile_show');
        }

        $metatitle = $this->get('translator')->trans('Edit user privacy', array(), 'syw_front_main_privacy_edit');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'online' => $online,
            'metatitle' => $metatitle,
            'title' => $title,
            'form' => $form->createView(),
            'languages' => $languages,
            'user' => $user
        );
        return $this->render('SywFrontMainBundle:Privacy:edit.html.twig', array_merge($return1, $return2));
    }
}
