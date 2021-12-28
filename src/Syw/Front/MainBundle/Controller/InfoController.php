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
use Syw\Front\MainBundle\Form\Type\UserProfileFormType;
use Syw\Front\MainBundle\Form\Type\CityFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Syw\Front\MainBundle\Manager\CitiesManager;

/**
 * Controller managing the user profile
 *
 * @category FormType
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class InfoController extends BaseController
{
    private $oldcity;
    private $oldcountry;

    /**
     * @Route("/info/edit")
     *
     * @Template()
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();

        if (false === is_object($user) || false === $user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $userProfile = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:UserProfile')
            ->findOneBy(array('user' => $user));
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));

        if (false === is_object($userProfile)) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $this->oldcity = $userProfile->getCity();
        $this->oldcountry = $userProfile->getCountry();

        $form = $this->createForm(
            new UserProfileFormType(
                $userProfile
            ),
            $userProfile
        );

        $city = new Cities();

        $cityform = $this->createForm(
            new CityFormType(
                $city
            ),
            $city
        );

        $cityform->handleRequest($request);
        $form->handleRequest($request);

        // if ($request->getMethod() == 'POST') {
        if ($cityform->isValid()) {
            $formData = $request->request->all();

            $em = $this->getDoctrine()->getManager();

            $em->persist($city);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->set('success', 'New city saved!');

        }

        if ($form->isValid()) {
            $formData = $request->request->all();

            $em = $this->getDoctrine()->getManager();
            if (true === isset($formData['userprofile']['city']) && trim($formData['userprofile']['city']) != "") {
                $cityfield = $formData['userprofile']['city'];
                $city_id   = preg_replace("`.*, ID:([0-9]+)\)$`", "$1", $cityfield);
                if (true === isset($city_id) && true === is_numeric($city_id)) {
                    $city = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:Cities')
                        ->findOneBy(array('id' => $city_id));
                    $userProfile->setCity($city);
                    $city->setUserNum($city->getUserNum()+1);
                    $em->persist($city);
                    if (true === isset($this->oldcity) && is_object($this->oldcity)) {
                        $this->oldcity->setUserNum($this->oldcity->getUserNum()-1);
                        $em->persist($this->oldcity);
                    }
                } else {
                    $userProfile->setCity($this->oldcity);
                }
            }

            if (true === isset($formData['userprofile']['country']) && trim($formData['userprofile']['country']) != "") {
                $countryfield = $formData['userprofile']['country'];
                $country_id   = preg_replace("`.* \(ID:([0-9]+)\)$`", "$1", $countryfield);
                if (true === isset($country_id) && true === is_numeric($country_id)) {
                    $country = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:Countries')
                        ->findOneBy(array('id' => $country_id));
                    $userProfile->setCountry($country);
                    $country->setUsersNum($country->getUsersNum()+1);
                    $em->persist($country);
                    if (true === isset($this->oldcountry) && is_object($this->oldcountry)) {
                        $this->oldcountry->setUsersNum($this->oldcountry->getUsersNum()-1);
                        $em->persist($this->oldcountry);
                    }
                } else {
                    $userProfile->setCountry($this->oldcountry);
                }
            }

            $em->persist($userProfile);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->set('success', 'User Information saved!');

            return $this->redirectToRoute('fos_user_profile_show');
        }

        $locale = $this->get('request')->getLocale();
        $language = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $locale));
        $metatitle = $this->get('translator')->trans('Edit profile information', array(), 'syw_front_main_info_edit');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'language' => $language->getLanguage(),
            'online' => $online,
            'metatitle' => $metatitle,
            'title' => $title,
            'form' => $form->createView(),
            'cityform' => $cityform->createView(),
            'languages' => $languages,
            'user' => $user
        );
        return $this->render('SywFrontMainBundle:Info:edit.html.twig', array_merge($return1, $return2));
    }

    /**
     * @Route("/info/addcity")
     */
    public function addcityAction(Request $request)
    {
        $user = $this->getUser();
        $userProfile = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:UserProfile')
            ->findOneBy(array('user' => $user));
        $this->oldcity = $userProfile->getCity();

        if (false === is_object($user) || false === $user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $formData = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        /* TODO: check for existence */
        $cityext = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Cities')
            ->findOneBy(array(
                'isoCountryCode' => strtoupper($formData['addcity']['isoCountryCode']),
                'name' => trim($formData['addcity']['name'])
            ));
        if (true === isset($cityext) && true === is_object($cityext)) {
            // city already exists!
            $city = $cityext;
            $city->setUserNum($city->getUserNum()+1);
            $em->persist($city);
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->set('success', 'That city already exists! Nevertheless it got stored in your profile.');
        } else {
            $city = new Cities();
            $city->setIsoCountryCode(strtoupper($formData['addcity']['isoCountryCode']));
            $city->setRegion($formData['addcity']['region']);
            $city->setName($formData['addcity']['name']);
            $city->setLatitude($formData['addcity']['latitude']);
            $city->setLongitude($formData['addcity']['longitude']);
            $city->setPopulation($formData['addcity']['population']);
            $city->setUserNum(1);
            $em->persist($city);
            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->set('success', 'New city saved and stored in your profile!');
        }
        $userProfile->setCity($city);
        $em->persist($userProfile);
        $country = $this->getDoctrine()
            ->getRepository('SywFrontMainBundle:Countries')
            ->findOneBy(array('code' => strtolower($city->getIsoCountryCode())));
        $country->setUsersNum($country->getUsersNum()+1);
        $em->persist($country);
        if (true === isset($this->oldcity) && is_object($this->oldcity)) {
            $this->oldcity->setUserNum($this->oldcity->getUserNum()-1);
            $em->persist($this->oldcity);
            $oldcountry = $this->getDoctrine()
                ->getRepository('SywFrontMainBundle:Countries')
                ->findOneBy(array('code' => strtolower($this->oldcity->getIsoCountryCode())));
            $oldcountry->setUsersNum($oldcountry->getUsersNum()-1);
            $em->persist($oldcountry);
        }

        $em->flush();

        return $this->redirectToRoute('syw_front_main_info_edit');
    }
}
