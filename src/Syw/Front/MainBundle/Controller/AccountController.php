<?php

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
 * Class AccountController
 *
 * @category Controller
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class AccountController extends BaseController
{
    /**
     * @Route("/account/delete")
     * @Method("GET")
     *
     * @Template()
     */
    public function deleteAction(Request $request)
    {
        $user = $this->getUser();
        if (false === is_object($user) || false === $user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $locale = $user->getLocale();
        $language = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $locale));
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        $metatitle = $this->get('translator')->trans('Delete your account', array(), 'syw_front_main_account_delete');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $host = $this->getHost();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'host' => $host,
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('Delete your account here.', array(), 'syw_front_main_account_delete'),
            'title' => $title,
            'language' => $language,
            'languages' => $languages,
            'user' => $user
        );
        return $this->render('SywFrontMainBundle:Account:delete.html.twig', array_merge($return1, $return2));
    }

    /**
     * @Route("/account/deletemenow")
     * @Method("POST")
     *
     * @Template()
     */
    public function delete2Action(Request $request)
    {
        $user = $this->getUser();
        if (false === is_object($user) || false === $user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $um = $this->get('fos_user.user_manager');
            $qb = $this->container->get('doctrine.dbal.default_connection');
            $machines = $em->getRepository('SywFrontMainBundle:Machines')->findBy(array('user' => $user));
            foreach ($machines as $machine) {
                unset($obj);
                $obj = $machine->getClass();
                if (true === isset($obj) && is_object($obj)) {
                    $obj->setMachinesNum($obj->getMachinesNum() - 1);
                    $em->persist($obj);
                }
                $machine->setClass(null);
                unset($obj);
                $obj = $machine->getCpu();
                if (true === isset($obj) && is_object($obj)) {
                    $obj->setMachinesNum($obj->getMachinesNum() - 1);
                    $em->persist($obj);
                }
                $machine->setCpu(null);
                unset($obj);
                $obj = $machine->getKernel();
                if (true === isset($obj) && is_object($obj)) {
                    $obj->setMachinesNum($obj->getMachinesNum() - 1);
                    $em->persist($obj);
                }
                $machine->setKernel(null);
                unset($obj);
                $obj = $machine->getArchitecture();
                if (true === isset($obj) && is_object($obj)) {
                    $obj->setMachinesNum($obj->getMachinesNum() - 1);
                    $em->persist($obj);
                }
                $machine->setArchitecture(null);
                unset($obj);
                $obj = $machine->getCountry();
                if (true === isset($obj) && is_object($obj)) {
                    $obj->setMachinesNum($obj->getMachinesNum() - 1);
                    $em->persist($obj);
                }
                $machine->setCountry(null);
                unset($obj);
                $obj = $machine->getDistribution();
                if (true === isset($obj) && is_object($obj)) {
                    $obj->setMachinesNum($obj->getMachinesNum() - 1);
                    $em->persist($obj);
                }
                $machine->setDistribution(null);
                unset($obj);
                $obj = $machine->getPurpose();
                if (true === isset($obj) && is_object($obj)) {
                    $obj->setMachinesNum($obj->getMachinesNum() - 1);
                    $em->persist($obj);
                }
                $machine->setPurpose(null);
                $em->persist($machine);
                $em->flush();
                $em->remove($machine);
                $em->flush();
            }
            $profile = $user->getProfile();
            if (true === isset($profile) && true === is_object($profile)) {
                $city = $profile->getCity();
                if (true === isset($city) && true === is_object($city)) {
                    $city->setUserNum($city->getUserNum() - 1);
                    $country = $em->getRepository('SywFrontMainBundle:Countries')->findOneBy(array('code' => strtolower($city->getIsoCountryCode())));
                    if (true === isset($country) && true === is_object($country)) {
                        $country->setUsersNum($country->getUsersNum() - 1);
                        $em->persist($country);
                    }
                }
            }
            $activities = $em->getRepository('SywFrontMainBundle:Activity')->findBy(array('user' => $user));
            foreach ($activities as $activity) {
                $qb->exec('DELETE FROM activity WHERE `id`=\''.$activity->getId().'\'');
            }

            $em->remove($user);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->set('success', 'User account and containing machines successfully deleted!');

            return $this->redirectToRoute("syw_front_main_main_index");
        }


        $locale = $user->getLocale();
        $language = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $locale));
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        $metatitle = $this->get('translator')->trans('Delete your account', array(), 'syw_front_main_account_delete');
        $title = $metatitle;
        $online = $this->getOnlineUsers();
        $host = $this->getHost();
        $return2 = $this->getTransForm($user);
        $return1 = array(
            'accountInfo' => $this->getAccountInfo(),
            'host' => $host,
            'online' => $online,
            'metatitle' => $metatitle,
            'metadescription' => $this->get('translator')->trans('Delete your account here.', array(), 'syw_front_main_account_delete'),
            'title' => $title,
            'language' => $language,
            'languages' => $languages,
            'user' => $user
        );
        return $this->render('SywFrontMainBundle:Account:delete2.html.twig', array_merge($return1, $return2));
    }
}
