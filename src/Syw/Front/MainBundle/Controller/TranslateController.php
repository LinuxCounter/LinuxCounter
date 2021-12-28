<?php

namespace Syw\Front\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Syw\Front\MainBundle\Form\Type\TranslationFormType;
use Asm\TranslationLoaderBundle\Entity\Translation;

/**
 * Class TranslateController
 *
 * @category Controller
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class TranslateController extends BaseController
{
    /**
     * @Route("/translate/thispag")
     * @Method("POST")
     *
     * @Template()
     */
    public function thispageAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $em       = $this->getDoctrine()->getManager();
            $formData = $request->request->all();
            $formData = $formData['form']['translations'];
            for ($i = 0; $i < count($formData); $i++) {
                $transKey      = $formData[$i]['transKey'];
                $transLocale   = $formData[$i]['transLocale'];
                $messageDomain = $formData[$i]['messageDomain'];
                $translation   = $formData[$i]['translation'];
                $trans         = $this->get('doctrine')
                    ->getRepository('AsmTranslationLoaderBundle:Translation')
                    ->findOneBy(array(
                        'transKey' => $transKey,
                        'transLocale' => $transLocale,
                        'messageDomain' => $messageDomain
                    ));
                if (true === isset($trans) && true === is_object($trans) && $trans != null) {
                    $trans->setTranslation($translation);
                    $trans->setDateUpdated(new \DateTime());
                    $em->persist($trans);
                    $em->flush();
                }
            }

            $kernel      = $this->get('kernel');
            $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
            $application->setAutoExit(false);
            $options = array('command' => 'doctrine:cache:clear-metadata');
            $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
            $options = array('command' => 'cache:clear');
            $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
            $options = array('command' => 'assets:install', "--symlink" => 'web');
            $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
            $options = array('command' => 'php app/console assetic:dump');
            $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
            $options = array('command' => 'asm:translations:dummy');
            $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
        }
        $session = $request->getSession();
        $lastroute = $session->get('last_route');
        if (false === isset($lastroute['name']) || trim($lastroute['name']) == "") {
            $lastroute['name'] = 'syw_front_main_main_index';
        }
        $url = $this->generateUrl($lastroute['name']);
        $response = new RedirectResponse($url);
        return $response;
    }
}
