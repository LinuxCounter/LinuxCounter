<?php

namespace Syw\Front\ManagerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Asm\TranslationLoaderBundle\Entity\Translation;
use Syw\Front\MainBundle\Entity\Cities;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MergeController extends BaseController
{
    /**
     * @Route("/manager/merge/city/{cityid}")
     * @Security("has_role('ROLE_MANAGER')")
     *
     * @Template()
     */
    public function mergeduplicatecitiesAction(Request $request, $cityid)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $user = $this->getUser();
        } else {
            $user = null;
        }

        $em = $this->getDoctrine()->getManager();

        $city       = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Cities')
            ->findOneBy(array('id' => $cityid));
        $duplicates = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Cities')
            ->findBy(array('name' => $city->getName(), 'isoCountryCode' => $city->getIsoCountryCode()), array('id' => 'ASC'));

        $duplicatesarray = array();
        foreach ($duplicates as $duplicate) {
            $duplicatesarray[$duplicate->getId()] =
                $duplicate->getName().", ".
                $duplicate->getIsoCountryCode().", ".
                $duplicate->getRegion().", ".
                $duplicate->getLatitude().", ".
                $duplicate->getLongitude();
        }

        $data = array();
        $form = $this->createFormBuilder(null, array('show_legend' => false))
            ->add('duplicates', 'choice', array(
                'choices' => $duplicatesarray,
                'multiple' => true,
            ))
            ->add('Merge these cities into one new city!', 'submit')
            ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            $data = $form->getData();

            if (count($data['duplicates']) >= 2) {
                $dups = array();
                $newcity = array();
                $newcity['usernum'] = 0;
                $userids = array();
                foreach ($data['duplicates'] as $duplicate) {
                    unset($city);
                    unset($users);
                    $city = $this->get('doctrine')
                        ->getRepository('SywFrontMainBundle:Cities')
                        ->findOneBy(array('id' => $duplicate));
                    $users = $city->getUsers();
                    foreach ($users as $user) {
                        $userids[] = $user;
                    }
                    $newcity['usernum'] += count($users);
                    $newcity['name'] = trim($city->getName());
                    $newcity['isoCountryCode'] = strtoupper(trim($city->getIsoCountryCode()));
                    if (trim($city->getLatitude()) != "") {
                        $newcity['latitude'] = (float)$city->getLatitude();
                    }
                    if (trim($city->getLongitude()) != "") {
                        $newcity['longitude'] = (float)$city->getLongitude();
                    }
                    if (trim($city->getRegion()) != "") {
                        $newcity['region'] = ucwords(trim($city->getRegion()));
                    }
                    if (intval($city->getPopulation()) >= 1) {
                        if (true === isset($newcity['population']) && intval($newcity['population']) < intval($city->getPopulation())) {
                            $newcity['population'] = intval($city->getPopulation());
                        } elseif (false === isset($newcity['population'])) {
                            $newcity['population'] = intval($city->getPopulation());
                        }
                    }
                }
                unset($city);
                $city = new Cities();
                $city->setIsoCountryCode($newcity['isoCountryCode']);
                $city->setName($newcity['name']);
                $city->setLatitude($newcity['latitude']);
                $city->setLongitude($newcity['longitude']);
                $city->setRegion($newcity['region']);
                $city->setPopulation($newcity['population']);
                $city->setUserNum($newcity['usernum']);
                $em->persist($city);
                $em->flush();
                foreach ($userids as $user) {
                    $user->setCity($city);
                    $em->flush();
                }
                foreach ($data['duplicates'] as $duplicate) {
                    $oldcity = $this->get('doctrine')
                        ->getRepository('SywFrontMainBundle:Cities')
                        ->findOneBy(array('id' => $duplicate));
                    $em->remove($oldcity);
                    $em->flush();
                }
                $flashBag = $this->get('session')->getFlashBag();
                $flashBag->set('success', 'Cities deleted and data merged to new city!');
                return $this->redirectToRoute('syw_front_manager_correct_correctcity', array('cityid' => $city->getId()));
            }
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
            'city' => $city,
            'duplicates' => $duplicates,
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
