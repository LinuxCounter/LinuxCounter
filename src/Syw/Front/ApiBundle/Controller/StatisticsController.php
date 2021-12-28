<?php

namespace Syw\Front\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\View;

use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Syw\Front\ApiBundle\Controller\BaseRestController;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

use Syw\Front\MainBundle\Entity\Machines;
use Syw\Front\MainBundle\Form\Type\MachineFormType;

class StatisticsController extends BaseRestController
{
    /**
     * @Route("/v1/statistics/user/cities/{page}", name="api_usercities_statistics")
     * @Method("GET")
     * @Rest\View()
     */
    public function statsUserCitiesAction(Request $request, $page)
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
                $em = $this->getDoctrine()->getManager();

                $user = $apiaccess->getUser();
                $apiaccess->setLastAccess(new \DateTime());
                $em->persist($apiaccess);
                $em->flush();

                if (false === isset($page)) {
                    $page = 1;
                }
                $numperpage = 10;
                $start = 0;
                if (true === isset($page) && intval($page) >= 2) {
                    $start = ($numperpage * $page) - $numperpage;
                }
                $dql   = "SELECT b FROM SywFrontMainBundle:Cities b WHERE b.usernum >= 1 ORDER BY b.usernum DESC, b.name ASC";
                $ent_cities = $em->createQuery($dql)
                    ->setMaxResults($numperpage)
                    ->setFirstResult($start)
                    ->getResult();

                $serializer = $this->container->get('serializer');
                $reports = $serializer->serialize($ent_cities, 'json');

                $response = new JsonResponse($reports);
                $response->setStatusCode(200);
            }
        }
        return $response;
    }
}
