<?php

namespace Syw\Front\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class SitemapsController
 *
 * @category Controller
 * @package  SywFrontMainBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class SitemapsController extends BaseController
{
    /**
     * @Route("/sitemap.{_format}", name="sample_sitemaps_sitemap", Requirements={"_format" = "xml"})
     * @Template("SywFrontMainBundle:Sitemaps:sitemap.xml.twig")
     */
    public function sitemapAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $urls = array();
        $hostname = $this->getRequest()->getHost();

        /** @var $router \Symfony\Component\Routing\Router */
        $router = $this->container->get('router');
        /** @var $collection \Symfony\Component\Routing\RouteCollection */
        $collection = $router->getRouteCollection();
        $allRoutes = $collection->all();

        $routes = array();

        /** @var $params \Symfony\Component\Routing\Route */
        foreach ($allRoutes as $route => $params) {
            $defaults = $params->getDefaults();

            if (isset($defaults['_controller'])) {
                $controllerAction = explode(':', $defaults['_controller']);
                $controller       = $controllerAction[0];




                if (preg_match("/ApiBundle/i", $controller) || preg_match("/MainBundle/i", $controller) || preg_match("/NewsBundle/i", $controller) || preg_match("/ToolBoxBundle/i", $controller)) {
                    if (!preg_match("/_gettranslateform/", $route) &&
                        !preg_match("/ajax/", $route) &&
                        !preg_match("/machine_/", $route) &&
                        !preg_match("/sitemap/", $route) &&
                        !preg_match("/account/", $route) &&
                        !preg_match("/signature/", $route) &&
                        !preg_match("/admin/", $route) &&
                        !preg_match("/email/", $route) &&
                        !preg_match("/addcity/", $route) &&
                        !preg_match("/confirm/", $route) &&
                        !preg_match("/main_main_lang/", $route) &&
                        !preg_match("/translate_thispage/", $route) &&
                        !preg_match("/news_add/", $route) &&
                        !preg_match("/edit/", $route) &&
                        !preg_match("/view/", $route) &&
                        !preg_match("/machine_delete/", $route) &&
                        !preg_match("/security_check/", $route) &&
                        !preg_match("/public_profile/", $route) &&
                        !preg_match("/public_machine/", $route) &&
                        !preg_match("/stats_cities/", $route) &&
                        !preg_match("/stats_countries/", $route) &&
                        !preg_match("/resetting_reset/", $route) &&
                        !preg_match("/api/", $route) &&
                        !preg_match("/error/", $route) &&
                        !preg_match("/security_check/", $route) &&
                        !preg_match("/remove/", $route)
                    ) {
                        $routes[] = $route;
                    }
                }
            }
        }

        // multi-lang pages
        foreach ($routes as $key => $route) {
            if (preg_match("/api_/i", $route)) {
                $urls[] = array(
                    'loc' => $route, // $this->get('router')->generate($route),
                    'changefreq' => 'monthly',
                    'priority' => '0.3'
                );
            } elseif (preg_match("/news_/i", $route)) {
                $urls[] = array(
                    'loc' => $route, // $this->get('router')->generate($route),
                    'changefreq' => 'weekly',
                    'priority' => '1.0'
                );
            } else {
                $urls[] = array(
                    'loc' => $route, // $this->get('router')->generate($route),
                    'changefreq' => 'monthly',
                    'priority' => '0.5'
                );
            }
        }

        return array('urls' => $urls, 'hostname' => $hostname);
    }
}
