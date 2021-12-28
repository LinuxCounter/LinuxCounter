<?php

namespace Syw\Front\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class PublicController
 *
 * @category Controller
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class SignatureImagesController extends BaseController
{
    /**
     * @Route("/cert/{usernumber}.png")
     * @Method("GET")
     */
    public function certAction($usernumber)
    {
        $updateinterval = 300;        // seconds

        $thisuser =  $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:User')
            ->findOneBy(array('id' => $usernumber));
        if (false === isset($thisuser) || false === is_object($thisuser) || $thisuser == null) {
            $response = new Response();
            $response->setStatusCode(404);
        } else {
            $template = 'bundles/sywfrontmain/images/lico-signature-template.png';
            $image = $usernumber.".png";
            $cert = 'cert/'.$image;
            if (false === is_dir('cert')) {
                mkdir('cert', 0777);
                chmod('cert', 0777);
            }

            $update = 0;
            if ((true === file_exists($cert) && filemtime($cert) <= (time() - $updateinterval)) ||
                false === file_exists($cert)) {
                $update = 1;
            }

            if ($update == 1) {
                $machines =  $this->get('doctrine')
                    ->getRepository('SywFrontMainBundle:Machines')
                    ->findBy(array('user' => $thisuser));
                $machinesonline =  $this->get('doctrine')
                    ->getRepository('SywFrontMainBundle:Machines')
                    ->findBy(array('user' => $thisuser, 'online' => 1));
                $machine_count = sizeof($machines);
                $machinesonline_count = sizeof($machinesonline);
                @unlink($cert);
                $imNeu = ImageCreateFromPNG($template);
                $black = ImageColorAllocate($imNeu, 0, 0, 0);
                $profile = $thisuser->getProfile();
                if (false === isset($profile) || false === is_object($profile) || $profile == null) {
                    $createdat = "unknown";
                } else {
                    $createdat = $profile->getCreatedAt()->format('Y-m-d');
                }
                imagestring($imNeu, 3, 20, 55, "Registered Linux user since ".$createdat."", $black);
                imagestring($imNeu, 5, 70, 78, "Linux User #".$thisuser->getId(), $black);
                imagestring($imNeu, 2, 20, 104, "This user has ".$machine_count." Linux machines registered.", $black);
                imagestring($imNeu, 2, 20, 116, "".$machinesonline_count." Linux machines are currently online.", $black);
                imagestring($imNeu, 1, 110, 134, "A free service from linuxcounter.net", $black);
                imagepng($imNeu, $cert);
            }

            header("Cache-Control: private, max-age=0, must-revalidate, no-store");
            header('Content-Type: image/png');
            $file = readfile($cert);
            $headers = array(
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline; filename="'.$image.'"',
                'Cache-Control' => 'private, max-age=0, must-revalidate, no-store'
            );
            $response = new Response($file, 200, $headers);
        }
        return $response;
    }

    /**
     * @Route("/mcert/{machinenumber}.png")
     * @Method("GET")
     */
    public function mcertAction($machinenumber)
    {
        $updateinterval = 300;        // seconds

        $thismachine =  $this->get('doctrine')
            ->getRepository('SywFrontMainBundle:Machines')
            ->findOneBy(array('id' => $machinenumber));
        if (false === isset($thismachine) || false === is_object($thismachine) || $thismachine == null) {
            $response = new Response();
            $response->setStatusCode(404);
        } else {
            $template = 'bundles/sywfrontmain/images/lico-signature-template.png';
            $image = $machinenumber.".png";
            $cert = 'mcert/'.$image;
            if (false === is_dir('mcert')) {
                mkdir('mcert', 0777);
                chmod('mcert', 0777);
            }

            $update = 0;
            if ((true === file_exists($cert) && filemtime($cert) <= (time() - $updateinterval)) ||
                false === file_exists($cert)) {
                $update = 1;
            }

            if ($update == 1) {
                $user =  $thismachine->getUser();
                $privacy =  $this->get('doctrine')
                    ->getRepository('SywFrontMainBundle:Privacy')
                    ->findOneBy(array('user' => $user));
                @unlink($cert);
                $imNeu = ImageCreateFromPNG($template);
                $black = ImageColorAllocate($imNeu, 0, 0, 0);

                if ($privacy->getSecretMachines() == 1) {
                    imagestring($imNeu, 5, 50, 78, "This machine is hidden!", $black);
                } else {
                    imagestring($imNeu, 2, 28, 55, "Registered Linux machine since ".$thismachine->getCreatedAt()->format('Y-m-d')."", $black);
                    imagestring($imNeu, 5, 50, 78, "Linux Machine #".$thismachine->getId(), $black);
                    $firstline = 0;
                    if ($firstline == 0 && $privacy->getShowDistribution() == 1) {
                        $obj = null;
                        $obj = $thismachine->getDistribution();
                        if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                            $firstline = 1;
                            imagestring($imNeu, 2, 20, 104, "Distribution: ".$obj->getName(), $black);
                            $distversion = $thismachine->getDistversion();
                            if (true === isset($distversion) && $distversion != null && $privacy->getShowVersions() == 1) {
                                imagestring($imNeu, 2, 185, 104, "Version: ".$distversion, $black);
                            }
                        }
                    }
                    if ($firstline == 0 && $privacy->getShowKernel() == 1 && $privacy->getShowVersions() == 1) {
                        $obj = null;
                        $obj = $thismachine->getKernel();
                        if (true === isset($obj) && true === is_object($obj) && $obj != null) {
                            $firstline = 1;
                            imagestring($imNeu, 2, 20, 104, "Kernel: ".$obj->getName(), $black);
                        }
                    }
                }
                imagestring($imNeu, 1, 110, 134, "A free service from linuxcounter.net", $black);
                imagepng($imNeu, $cert);
            }

            header("Cache-Control: private, max-age=0, must-revalidate, no-store");
            header('Content-Type: image/png');
            $file = readfile($cert);
            $headers = array(
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline; filename="'.$image.'"',
                'Cache-Control' => 'private, max-age=0, must-revalidate, no-store'
            );
            $response = new Response($file, 200, $headers);
        }
        return $response;
    }
}
