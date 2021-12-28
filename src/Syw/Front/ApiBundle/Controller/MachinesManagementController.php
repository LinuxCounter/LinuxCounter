<?php

namespace Syw\Front\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\View;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\RestBundle\Controller\Annotations as Rest;
use Syw\Front\MainBundle\Entity\Machines;
use Syw\Front\MainBundle\Entity\Kernels;

class MachinesManagementController extends BaseRestController
{
    /**
     * @Route("/v1/machines", name="api_create_machine")
     * @Method("POST")
     * @Rest\View()
     */
    public function createAction(Request $request)
    {
        $aResponse = array();
        $apikey = $request->headers->get('x-lico-apikey');
        if (false === isset($apikey) || trim($apikey) == "" || strlen($apikey) != 32 || false === preg_match("`^([a-z0-9]{32})$`", $apikey)) {
            $response = new JsonResponse($aResponse);
            $response->setStatusCode(400);
        } else {
            $apiaccess = $this->get('doctrine')
                ->getRepository('SywFrontApiBundle:ApiAccess')
                ->findOneBy(array('apikey' => $apikey));
            if (false === isset($apiaccess) || false === is_object($apiaccess) || $apiaccess == null) {
                $response = new JsonResponse($aResponse);
                $response->setStatusCode(404);
            } else {
                $user = $apiaccess->getUser();
                $em = $this->getDoctrine()->getManager();
                $machine = new Machines();
                $machine->setCreatedAt(new \DateTime());
                $machine->setUser($user);
                $updateKey = $password = mt_rand(10000000, 99999999);
                $machine->setUpdateKey($updateKey);
                $em->persist($machine);
                $em->flush();
                $machine_id =  $machine->getId();
                $aResponse = array(
                    'machine_id' => $machine_id,
                    'machine_updatekey' => $updateKey
                );
                $apiaccess->setLastAccess(new \DateTime());
                $em->persist($apiaccess);
                $em->flush();
                $response = new JsonResponse($aResponse);
                $response->setStatusCode(200);
            }
        }
        return $response;
    }

    /**
     * @Route("/v1/machines/{machine_id}", name="api_update_machine")
     * @Method({"PATCH", "PUT"})
     * @Rest\View()
     */
    public function updateAction(Request $request, $machine_id)
    {
        $aResponse = array();
        $machine_updatekey = $request->headers->get('x-lico-machine-updatekey');
        if (false === isset($machine_updatekey) || trim($machine_updatekey) == "" || false === preg_match("`^([a-zA-Z0-9]+)$`", $machine_updatekey)) {
            $response = new JsonResponse($aResponse);
            $response->setStatusCode(400);
        } else {
            $machine = $this->get('doctrine')
                ->getRepository('SywFrontMainBundle:Machines')
                ->findOneBy(array('id' => $machine_id, 'updateKey' => $machine_updatekey));
            if (false === isset($machine) || false === is_object($machine) || $machine == null) {
                $response = new JsonResponse($aResponse);
                $response->setStatusCode(404);
            } else {
                $em      = $this->getDoctrine()->getManager();

                $hostname = $request->request->get('hostname');
                if (true === isset($hostname) && trim($hostname) != "") {
                    $machine->setHostname($hostname);
                }

                $obj = null;
                $var = $request->request->get('country');
                if (true === isset($var) && trim($var) != "") {
                    $obj = $this->get('doctrine')
                        ->getRepository('SywFrontMainBundle:Countries')
                        ->findOneBy(array('code' => strtolower($var)));
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $machine->setCountry($obj);
                    }
                }

                $online = $request->request->get('online');
                if (true === isset($online) && trim($online) != "") {
                    $machine->setOnline($online);
                }

                $obj = null;
                $var = $request->request->get('class');
                if (true === isset($var) && trim($var) != "") {
                    $obj = $this->get('doctrine')
                        ->getRepository('SywFrontMainBundle:Classes')
                        ->findOneBy(array('name' => $var));
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $machine->setClass($obj);
                    }
                }

                $obj = null;
                $var = $request->request->get('distribution');
                if (true === isset($var) && trim($var) != "") {
                    $obj = $this->get('doctrine')
                        ->getRepository('SywFrontMainBundle:Distributions')
                        ->findOneBy(array('name' => $var));
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $machine->setDistribution($obj);
                    }
                }

                $distversion = $request->request->get('distversion');
                if (true === isset($distversion) && trim($distversion) != "") {
                    $machine->setDistversion($distversion);
                }

                $obj = null;
                $var = $request->request->get('architecture');
                if (true === isset($var) && trim($var) != "") {
                    if (false !== stripos($var, "arm") && false !== stripos($var, "64")) {
                        $newarch = "arm64";
                    } elseif (false !== stripos($var, "raspberry")) {
                        $newarch = "arm";
                    } elseif (false !== stripos($var, "arm")) {
                        $newarch = "arm";
                    } elseif (false !== stripos($var, "amd") && false !== stripos($var, "64")) {
                        $newarch = "amd64";
                    } elseif (false !== stripos($var, "x86") && false !== stripos($var, "64")) {
                        $newarch = "x86_64";
                    } elseif (false !== stripos($var, "x86")) {
                        $newarch = "x86";
                    } elseif (preg_match("`[xi]+-?[2-7]+86`i", $var)) {
                        $newarch = "i".preg_replace("`.*[xi]+-?([2-7]+86).*`i", "$1", $var);
                    } elseif (false !== stripos($var, "power") && false !== stripos($var, "64")) {
                        $newarch = "ppc64";
                    } elseif (false !== stripos($var, "intel core")) {
                        $newarch = "i686";
                    } elseif (false !== stripos($var, "power")) {
                        $newarch = "ppc";
                    } elseif (false !== stripos($var, "mips") && false !== stripos($var, "64")) {
                        $newarch = "mips64";
                    } elseif (false !== stripos($var, "mips")) {
                        $newarch = "mips";
                    } elseif (false !== stripos($var, "sparc") && false !== stripos($var, "64")) {
                        $newarch = "sparc64";
                    } elseif (false !== stripos($var, "sparc")) {
                        $newarch = "sparc";
                    } elseif (false !== stripos($var, "sun")) {
                        $newarch = "sparc";
                    } elseif (false !== stripos($var, "risc") && false !== stripos($var, "64")) {
                        $newarch = "risc64";
                    } elseif (false !== stripos($var, "risc")) {
                        $newarch = "risc";
                    } elseif (false !== stripos($var, "alpha") && false !== stripos($var, "64")) {
                        $newarch = "alpha64";
                    } elseif (false !== stripos($var, "alpha")) {
                        $newarch = "alpha";
                    } else {
                        $newarch = "unknown";
                    }
                    $obj = $this->get('doctrine')
                        ->getRepository('SywFrontMainBundle:Architectures')
                        ->findOneBy(array('name' => $newarch));
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $machine->setArchitecture($obj);
                    }
                }

                $obj = null;
                $var = $request->request->get('kernel');
                if (true === isset($var) && trim($var) != "") {
                    # trim the given kernel to major version, ie:  3.13.2
                    $version = preg_replace("`^([^\.-]+)\.([^\.-]+\.?[^\.-]*).*$`i", "$1.$2", trim($var));
                    $version = trim($version);
                    $obj = $this->get('doctrine')
                        ->getRepository('SywFrontMainBundle:Kernels')
                        ->findOneBy(array('name' => $version));
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $machine->setKernel($obj);
                    } else {
                        $kernel = new Kernels();
                        $kernel->setName($version);
                        $kernel->setMachinesNum(1);
                        $em->persist($kernel);
                        $machine->setKernel($kernel);
                    }
                }

                $obj = null;
                $var = $request->request->get('cpu');
                if (true === isset($var) && trim($var) != "") {
                    $obj = $this->get('doctrine')
                        ->getRepository('SywFrontMainBundle:Cpus')
                        ->findOneBy(array('name' => $var));
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $machine->setCpu($obj);
                    }
                }

                $obj = null;
                $var = $request->request->get('purpose');
                if (true === isset($var) && trim($var) != "") {
                    $obj = $this->get('doctrine')
                        ->getRepository('SywFrontMainBundle:Purposes')
                        ->findOneBy(array('name' => $var));
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $machine->setPurpose($obj);
                    }
                }

                $cores = $request->request->get('cores');
                if (true === isset($cores) && trim($cores) != "") {
                    $machine->setCores($cores);
                }

                $flags = $request->request->get('flags');
                if (true === isset($flags) && trim($flags) != "") {
                    $machine->setFlags($flags);
                }

                $diskspace = $request->request->get('diskspace');
                if (true === isset($diskspace) && trim($diskspace) != "") {
                    $machine->setDiskspace($diskspace);
                }

                $diskspaceFree = $request->request->get('diskspaceFree');
                if (true === isset($diskspaceFree) && trim($diskspaceFree) != "") {
                    $machine->setDiskspaceFree($diskspaceFree);
                }

                $memory = $request->request->get('memory');
                if (true === isset($memory) && trim($memory) != "") {
                    $machine->setMemory($memory);
                }

                $memoryFree = $request->request->get('memoryFree');
                if (true === isset($memoryFree) && trim($memoryFree) != "") {
                    $machine->setMemoryFree($memoryFree);
                }

                $swap = $request->request->get('swap');
                if (true === isset($swap) && trim($swap) != "") {
                    $machine->setSwap($swap);
                }

                $swapFree = $request->request->get('swapFree');
                if (true === isset($swapFree) && trim($swapFree) != "") {
                    $machine->setSwapFree($swapFree);
                }

                $mailer = $request->request->get('mailer');
                if (true === isset($mailer) && trim($mailer) != "") {
                    $machine->setMailer($mailer);
                }

                $network = $request->request->get('network');
                if (true === isset($network) && trim($network) != "") {
                    $machine->setNetwork($network);
                }

                $accounts = $request->request->get('accounts');
                if (true === isset($accounts) && trim($accounts) != "") {
                    $machine->setAccounts($accounts);
                }

                $uptime = $request->request->get('uptime');
                if (true === isset($uptime) && trim($uptime) != "") {
                    /**
                     * Todo: reformat and convert the sent uptime to a simple amounts of seconds (integer)
                     */
                    // 00:01:42         01:14:43             12345678            up 2 days,  3:20            up  2:26
                    $uptime = trim($uptime);
                    $secs = 0;
                    $days = 0;
                    $hours = 0;
                    $minutes = 0;
                    $seconds = 0;
                    if (preg_match("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", $uptime)) {
                        $hours      = preg_replace("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", "$1", $uptime);
                        $minutes    = preg_replace("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", "$2", $uptime);
                        $seconds    = preg_replace("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", "$3", $uptime);
                        $secs +=  (intval($hours) * 60 * 60);
                        $secs += (intval($minutes) * 60);
                        if (true === isset($seconds) && intval($seconds) >= 1) {
                            $secs += intval($seconds);
                        }
                    } else if (true === is_numeric($uptime) && intval($uptime) >= 1) {
                        $secs = $uptime;
                    } else if (stripos($uptime, "day") >= 1) {
                        if (preg_match("`.*up\s+([0-9]+)\s+day.*`", $uptime)) {
                            $days = preg_replace("`.*up\s+([0-9]+)\s+day.*`", "$1", $uptime);
                        } else if (preg_match("`^([0-9]+)\s+day.*`", $uptime)) {
                            $days = preg_replace("`^([0-9]+)\s+day.*`", "$1", $uptime);
                        }
                        if (stripos($uptime, ",") && preg_match("`[0-9]:[0-9]`", $uptime)) {
                            $split = explode(",", $uptime);
                            $time = trim($split);
                            $hours      = preg_replace("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", "$1", $time);
                            $minutes    = preg_replace("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", "$2", $time);
                            $seconds    = preg_replace("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", "$3", $time);
                        }
                        if (true === isset($days) && intval($days) >= 1) {
                            $secs += (intval($days) * 24 * 60 * 60);
                        }
                        if (true === isset($hours) && intval($hours) >= 1) {
                            $secs += (intval($hours) * 60 * 60);
                        }
                        if (true === isset($minutes) && intval($minutes) >= 1) {
                            $secs += (intval($minutes) * 60);
                        }
                        if (true === isset($seconds) && intval($seconds) >= 1) {
                            $secs += intval($seconds);
                        }
                    } else if (stripos($uptime, "up") >= 1) {
                        $uptime = str_replace("up", "", $uptime);
                        $uptime = trim($uptime);
                        $hours      = preg_replace("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", "$1", $uptime);
                        $minutes    = preg_replace("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", "$2", $uptime);
                        $seconds    = preg_replace("`^([0-9]{2}):([0-9]{2}):?([0-9]{2})?$`", "$3", $uptime);
                        $secs +=  (intval($hours) * 60 * 60);
                        $secs += (intval($minutes) * 60);
                        if (true === isset($seconds) && intval($seconds) >= 1) {
                            $secs += intval($seconds);
                        }
                    }
                    $machine->setUptime($secs);
                }

                $loadavg = $request->request->get('loadavg');
                if (true === isset($loadavg) && trim($loadavg) != "") {
                    $machine->setLoadAvg($loadavg);
                }

                $machine->setModifiedAt(new \DateTime());
                $em->persist($machine);
                $em->flush();

                $apiaccess = $this->get('doctrine')
                    ->getRepository('SywFrontApiBundle:ApiAccess')
                    ->findOneBy(array('user' => $machine->getUser()));
                $apiaccess->setLastAccess(new \DateTime());
                $em->persist($apiaccess);
                $em->flush();

                $aResponse  = array();
                $response = new JsonResponse($aResponse);
                $response->setStatusCode(204);
            }
        }
        return $response;
    }

    /**
     * @Route("/v1/machines", name="api_list_machines")
     * @Method("GET")
     * @Rest\View()
     */
    public function listAllAction(Request $request)
    {
        $aResponse = array();
        $apikey = $request->headers->get('x-lico-apikey');
        if (false === isset($apikey) || trim($apikey) == "" || strlen($apikey) != 32 || false === preg_match("`^([a-z0-9]{32})$`", $apikey)) {
            $response = new JsonResponse($aResponse);
            $response->setStatusCode(400);
        } else {
            $apiaccess = $this->get('doctrine')
                ->getRepository('SywFrontApiBundle:ApiAccess')
                ->findOneBy(array('apikey' => $apikey));
            if (false === isset($apiaccess) || false === is_object($apiaccess) || $apiaccess == null) {
                $response = new JsonResponse($aResponse);
                $response->setStatusCode(404);
            } else {
                $user = $apiaccess->getUser();
                $machines = $this->get('doctrine')
                    ->getRepository('SywFrontMainBundle:Machines')
                    ->findBy(array('user' => $user));
                $em = $this->getDoctrine()->getManager();
                $apiaccess = $this->get('doctrine')
                    ->getRepository('SywFrontApiBundle:ApiAccess')
                    ->findOneBy(array('user' => $user));
                $apiaccess->setLastAccess(new \DateTime());
                $em->persist($apiaccess);
                $em->flush();
                foreach ($machines as $machine) {
                    $aResponse[] = array(
                        'machine_id' => $machine->getId(),
                        'machine_updatekey' => $machine->getUpdateKey(),
                        'machine_createdat' => $machine->getCreatedAt(),
                        'machine_modifiedat' => $machine->getModifiedAt()
                    );
                }
                $response = new JsonResponse($aResponse);
                $response->setStatusCode(200);
            }
        }
        return $response;
    }

    /**
     * @Route("/v1/machines/{machine_id}", name="api_list_machine")
     * @Method("GET")
     * @Rest\View()
     */
    public function listOneAction(Request $request, $machine_id)
    {
        $aResponse = array();
        $apikey = $request->headers->get('x-lico-apikey');
        if (false === isset($apikey) || trim($apikey) == "" || strlen($apikey) != 32 || false === preg_match("`^([a-z0-9]{32})$`", $apikey)) {
            $response = new JsonResponse($aResponse);
            $response->setStatusCode(400);
        } else {
            $apiaccess = $this->get('doctrine')
                ->getRepository('SywFrontApiBundle:ApiAccess')
                ->findOneBy(array('apikey' => $apikey));
            if (false === isset($apiaccess) || false === is_object($apiaccess) || $apiaccess == null) {
                $response = new JsonResponse($aResponse);
                $response->setStatusCode(404);
            } else {
                $user    = $apiaccess->getUser();
                $machine = $this->get('doctrine')
                    ->getRepository('SywFrontMainBundle:Machines')
                    ->findOneBy(array('id' => $machine_id, 'user' => $user));

                if (false === isset($machine) || false === is_object($machine) || $machine == null) {
                    $response = new JsonResponse($aResponse);
                    $response->setStatusCode(404);
                } else {
                    $obj = null;
                    $obj = $machine->getDistribution();
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $distribution = $obj->getName();
                    } else {
                        $distribution = null;
                    }

                    $obj = null;
                    $obj = $machine->getKernel();
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $kernel = $obj->getName();
                    } else {
                        $kernel = null;
                    }

                    $obj = null;
                    $obj = $machine->getCpu();
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $cpu = $obj->getName();
                    } else {
                        $cpu = null;
                    }

                    $obj = null;
                    $obj = $machine->getCountry();
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $country = strtoupper($obj->getCode());
                    } else {
                        $country = null;
                    }

                    $obj = null;
                    $obj = $machine->getArchitecture();
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $architecture = $obj->getName();
                    } else {
                        $architecture = null;
                    }

                    $obj = null;
                    $obj = $machine->getClass();
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $class = $obj->getName();
                    } else {
                        $class = null;
                    }

                    $obj = null;
                    $obj = $machine->getPurpose();
                    if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                        $purpose = $obj->getName();
                    } else {
                        $purpose = null;
                    }

                    $aResponse = array(
                        'machine_id' => $machine->getId(),
                        'machine_updatekey' => $machine->getUpdateKey(),
                        'machine_user' => $machine->getUser()->getId(),
                        'machine_hostname' => $machine->getHostname(),
                        'machine_cores' => $machine->getCores(),
                        'machine_flags' => $machine->getFlags(),
                        'machine_accounts' => $machine->getAccounts(),
                        'machine_diskspace' => $machine->getDiskspace(),
                        'machine_diskspaceFree' => $machine->getDiskspaceFree(),
                        'machine_memory' => $machine->getMemory(),
                        'machine_memoryFree' => $machine->getMemoryFree(),
                        'machine_swap' => $machine->getSwap(),
                        'machine_swapFree' => $machine->getSwapFree(),
                        'machine_distversion' => $machine->getDistversion(),
                        'machine_mailer' => $machine->getMailer(),
                        'machine_network' => $machine->getNetwork(),
                        'machine_online' => $machine->getOnline(),
                        'machine_uptime' => $machine->getUptime(),
                        'machine_loadavg' => $machine->getLoadAvg(),
                        'machine_distribution' => $distribution,
                        'machine_kernel' => $kernel,
                        'machine_cpu' => $cpu,
                        'machine_country' => $country,
                        'machine_architecture' => $architecture,
                        'machine_class' => $class,
                        'machine_purpose' => $purpose,
                        'machine_createdat' => $machine->getCreatedAt(),
                        'machine_modifiedat' => $machine->getModifiedAt()
                    );
                    $response  = new JsonResponse($aResponse);
                    $response->setStatusCode(200);
                    $em = $this->getDoctrine()->getManager();
                    $apiaccess->setLastAccess(new \DateTime());
                    $em->persist($apiaccess);
                    $em->flush();
                }
            }
        }
        return $response;
    }

    /**
     * @Route("/v1/machines/{machine_id}", name="api_delete_machine")
     * @Method("DELETE")
     * @Rest\View()
     */
    public function deleteAction(Request $request, $machine_id)
    {
        $aResponse = array();
        $apikey = $request->headers->get('x-lico-apikey');
        if (false === isset($apikey) || trim($apikey) == "" || strlen($apikey) != 32 || false === preg_match("`^([a-z0-9]{32})$`", $apikey)) {
            $response = new JsonResponse($aResponse);
            $response->setStatusCode(400);
        } else {
            $apiaccess = $this->get('doctrine')
                ->getRepository('SywFrontApiBundle:ApiAccess')
                ->findOneBy(array('apikey' => $apikey));
            if (false === isset($apiaccess) || false === is_object($apiaccess) || $apiaccess == null) {
                $response = new JsonResponse($aResponse);
                $response->setStatusCode(404);
            } else {
                $user = $apiaccess->getUser();
                $em      = $this->getDoctrine()->getManager();

                $machine = $this->get('doctrine')
                    ->getRepository('SywFrontMainBundle:Machines')
                    ->findOneBy(array('id' => $machine_id, 'user' => $user));

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

                $apiaccess->setLastAccess(new \DateTime());
                $em->persist($apiaccess);
                $em->flush();

                $response = new JsonResponse($aResponse);
                $response->setStatusCode(204);
            }
        }
        return $response;
    }
}
