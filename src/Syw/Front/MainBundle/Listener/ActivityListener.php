<?php

namespace Syw\Front\MainBundle\Listener;

use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Syw\Front\MainBundle\Entity\Activity;
use Syw\Front\MainBundle\Util\DetectBotFromUserAgent;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernel;

/**
 * Class Activity
 *
 * @category Listener
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class ActivityListener
{
    protected $context;
    protected $em;
    protected $container;

    public function __construct(ContainerInterface $container, SecurityContext $context, Doctrine $doctrine)
    {
        $this->context = $context;
        $this->em = $doctrine->getManager();
        $this->container = $container;
    }

    /**
     * On each request we want to update the user's last activity datetime
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterControllerEvent $event
     * @return void
     */
    public function onCoreController(FilterControllerEvent $event)
    {
        if (true === isset($this->context) && true === is_object($this->context)) {
            if (true === is_object($this->context->getToken()) && $this->context->getToken() != null) {
                $user = $this->context->getToken()->getUser();
            }
        }
        if (false === isset($user) || false === is_object($user) || $user == null) {
            $user = null;
        }
        $route  = $event->getRequest()->attributes->get('_route');
        $request = $event->getRequest();
        $session = $request->getSession();
        $routeParams = $request->get('_route_params');
        if ($route[0] == '_') {
            return;
        }
        $routeData = ['name' => $route, 'params' => $routeParams];
        $thisRoute = $session->get('this_route', []);

        if (true === isset($_SERVER["REQUEST_URI"]) && trim($_SERVER["REQUEST_URI"]) != "") {
            if (true === isset($_COOKIE['LICO_URL_2']) && trim($_COOKIE['LICO_URL_2']) != "") {
                setcookie('LICO_URL_3', urldecode(trim($_COOKIE['LICO_URL_2'])), time() + 3600, '/');
            }
            if (true === isset($_COOKIE['LICO_URL_1']) && trim($_COOKIE['LICO_URL_1']) != "") {
                setcookie('LICO_URL_2', urldecode(trim($_COOKIE['LICO_URL_1'])), time() + 3600, '/');
            }
            if (true === isset($_COOKIE['LICO_URL_0']) && trim($_COOKIE['LICO_URL_0']) != "") {
                setcookie('LICO_URL_1', urldecode(trim($_COOKIE['LICO_URL_0'])), time() + 3600, '/');
            }
            setcookie('LICO_URL_0', $_SERVER["REQUEST_URI"], time() + 3600, '/');
        }

        $session->set('last_route', $thisRoute);
        $session->set('this_route', $routeData);

        if ($route == null || true === in_array($route, array('_wdt'))) {
            return true;
        }
        $ipaddress = $this->container->get('request')->server->get("REMOTE_ADDR");
        if ($ipaddress == "127.0.0.1") {
            if (true === isset($_SERVER["REMOTE_ADDR"]) && trim($_SERVER["REMOTE_ADDR"]) != "") {
                $ipaddress = $_SERVER["REMOTE_ADDR"];
            } else {
                $ipaddress = "N/A";
            }
        }
        $useragent = $this->container->get('request')->server->get("HTTP_USER_AGENT");
        $obj       = new DetectBotFromUserAgent();
        $isbot     = $obj->licoIsBot($useragent, $ipaddress);

        $activity = new Activity();
        $activity->setUser($user);
        $activity->setRoute($route);

        $activity->setIpAddress($ipaddress);
        $activity->setUserAgent($useragent);
        $activity->setIsBot($isbot);

        $activity->setCreatedAt(new \DateTime());
        $this->em->persist($activity);
        $this->em->flush();
    }
}
