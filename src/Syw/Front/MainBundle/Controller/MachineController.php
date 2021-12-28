<?php

namespace Syw\Front\MainBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Syw\Front\MainBundle\Entity\Machines;
use Syw\Front\MainBundle\Manager\MachinesManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Syw\Front\MainBundle\Form\Type\MachineFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class MachineController
 *
 * @category FormType
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class MachineController extends BaseController
{
    private $oldCountry;
    private $oldClass;
    private $oldDist;
    private $oldArch;
    private $oldKernel;
    private $oldCpu;


    /**
     * @Route("/profile/machine/new")
     *
     * @Template()
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        $machine = new Machines();

        $form = $this->createForm(
            new MachineFormType(
                $machine
            ),
            $machine
        );

        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            $formData = $request->request->all();

            $em = $this->getDoctrine()->getManager();

            $field = array('Countries', 'country');
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setCountry($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                }
            }

            $field = array('Classes', 'class');
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setClass($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                }
            }

            $field = array('Distributions', 'distribution');
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setDistribution($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                }
            }

            $field = array('Architectures', 'architecture');
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setArchitecture($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                }
            }

            $field = array('Kernels', 'kernel');
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setKernel($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                }
            }

            $field = array('Cpus', 'cpu');
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setCpu($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                }
            }

            $machine->setCreatedAt(new \DateTime());
            $machine->setUser($user);
            $updateKey = $password = mt_rand(10000000, 99999999);
            $machine->setUpdateKey($updateKey);

            $em->persist($machine);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->set('success', 'Machine created!');

            return $this->redirectToRoute('fos_user_profile_show');
        }

        $locale = $this->get('request')->getLocale();
        $language = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $locale));
        $metatitle = $this->get('translator')->trans('New Machine Creation', array(), 'syw_front_main_machine_create');
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
            'machine' => $machine,
            'languages' => $languages,
            'user' => $user
        );
        return $this->render('SywFrontMainBundle:Machine:create.html.twig', array_merge($return1, $return2));
    }

    /**
     * @Route("/profile/machine/edit/{machinenumber}")
     *
     * @Template()
     */
    public function editAction(Request $request, $machinenumber)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        $machine = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Machines')
            ->findOneBy(array('user' => $user, 'id' => $machinenumber));

        $this->oldCountry = $machine->getCountry();
        $this->oldClass = $machine->getClass();
        $this->oldDist = $machine->getDistribution();
        $this->oldArch = $machine->getArchitecture();
        $this->oldKernel = $machine->getKernel();
        $this->oldCpu = $machine->getCpu();

        $form = $this->createForm(
            new MachineFormType(
                $machine
            ),
            $machine
        );

        $form->handleRequest($request);

        if ($request->getMethod() == 'POST') {
            $formData = $request->request->all();

            $em = $this->getDoctrine()->getManager();

            $field = array('Countries', 'country', $this->oldCountry);
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setCountry($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                    if (true === isset($field[2]) && is_object($field[2])) {
                        $field[2]->setMachinesNum($field[2]->getMachinesNum() - 1);
                        $em->persist($field[2]);
                    }
                } else {
                    $machine->setCountry($field[2]);
                }
            }

            $field = array('Classes', 'class', $this->oldClass);
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setClass($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                    if (true === isset($field[2]) && is_object($field[2])) {
                        $field[2]->setMachinesNum($field[2]->getMachinesNum() - 1);
                        $em->persist($field[2]);
                    }
                } else {
                    $machine->setClass($field[2]);
                }
            }

            $field = array('Distributions', 'distribution', $this->oldDist);
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setDistribution($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                    if (true === isset($field[2]) && is_object($field[2])) {
                        $field[2]->setMachinesNum($field[2]->getMachinesNum() - 1);
                        $em->persist($field[2]);
                    }
                } else {
                    $machine->setDistribution($field[2]);
                }
            }

            $field = array('Architectures', 'architecture', $this->oldArch);
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setArchitecture($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                    if (true === isset($field[2]) && is_object($field[2])) {
                        $field[2]->setMachinesNum($field[2]->getMachinesNum() - 1);
                        $em->persist($field[2]);
                    }
                } else {
                    $machine->setArchitecture($field[2]);
                }
            }

            $field = array('Kernels', 'kernel', $this->oldKernel);
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setKernel($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                    if (true === isset($field[2]) && is_object($field[2])) {
                        $field[2]->setMachinesNum($field[2]->getMachinesNum() - 1);
                        $em->persist($field[2]);
                    }
                } else {
                    $machine->setKernel($field[2]);
                }
            }

            $field = array('Cpus', 'cpu', $this->oldCpu);
            if (true === isset($formData['machine'][$field[1]]) && trim($formData['machine'][$field[1]]) != "") {
                $val = $formData['machine'][$field[1]];
                $id   = preg_replace("`.*\(ID:([0-9]+)\)$`", "$1", $val);
                if (true === isset($id) && true === is_numeric($id)) {
                    $obj = $this->getDoctrine()
                        ->getRepository('SywFrontMainBundle:'.$field[0])
                        ->findOneBy(array('id' => $id));
                    $machine->setCpu($obj);
                    $obj->setMachinesNum($obj->getMachinesNum()+1);
                    $em->persist($obj);
                    if (true === isset($field[2]) && is_object($field[2])) {
                        $field[2]->setMachinesNum($field[2]->getMachinesNum() - 1);
                        $em->persist($field[2]);
                    }
                } else {
                    $machine->setCpu($field[2]);
                }
            }
            $machine->setModifiedAt(new \DateTime());
            $em->persist($machine);
            $em->flush();

            $flashBag = $this->get('session')->getFlashBag();
            $flashBag->set('success', 'Machine saved!');

            return $this->redirectToRoute('fos_user_profile_show');
        }

        $locale = $this->get('request')->getLocale();
        $language = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findOneBy(array('locale' => $locale));
        $metatitle = $this->get('translator')->trans('Edit Machine', array(), 'syw_front_main_machine_edit');
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
            'machine' => $machine,
            'languages' => $languages,
            'user' => $user
        );
        return $this->render('SywFrontMainBundle:Machine:edit.html.twig', array_merge($return1, $return2));
    }

    /**
     * @Route("/profile/machine/confirm/{machinenumber}")
     * @Method("GET")
     *
     * @Template()
     */
    public function confirmAction(Request $request, $machinenumber)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        $myobject   = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Machines')
            ->findOneBy(array('user' => $user, 'id' => $machinenumber));

        if (!$myobject) {
            // throw error
        } else {
            // you can pass information about your object to the confirmation message
            $myobjectInfo = array(
                'yes' => 'syw_front_main_machine_delete', // path to the deleteAction, required
                'no' => 'fos_user_profile_show', // path if cancel delete, required
                // put any information here. I used type, name and id
                // but you can add what you want
                'type' => 'machine',
                'id' => $myobject->getId(), // required for deleteAction path
                'hostname' => $myobject->getHostname()
            );
            // add informations to session variable
            $this->get('session')->set('confirmation', $myobjectInfo);
            return $this->redirect($this->generateUrl('syw_front_main_machine_edit', array('machinenumber' => $myobject->getId())));
        }
    }

    /**
     * @Route("/profile/machine/delete/{id}")
     * @Method("POST")
     *
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $machinenumber = $id;

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $languages = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Languages')
            ->findBy(array('active' => 1), array('language' => 'ASC'));
        $machine   = $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Machines')
            ->findOneBy(array('user' => $user, 'id' => $machinenumber));

        $em = $this->getDoctrine()->getManager();
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

        $flashBag = $this->get('session')->getFlashBag();
        $flashBag->set('success', 'Machine deleted!');

        return $this->redirectToRoute('fos_user_profile_show');
    }
}
