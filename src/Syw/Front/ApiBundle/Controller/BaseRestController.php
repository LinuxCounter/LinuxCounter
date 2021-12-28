<?php

namespace Syw\Front\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BaseRestController
 *
 * @category Controller
 * @package  SywFrontApiBundle
 * @author   Christin Löhner <alex.loehner@linux.com>
 * @license  GPL v3
 * @link     https://github.com/christinloehner/linuxcounter.new
 */
class BaseRestController extends FOSRestController
{
    /**
     * Returns the Doctrine EntityManager from the Container
     *
     * @param  string $repository_name Entity Repository name in Bundle:Entity format
     *
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }


    /**
     * Returns the EntityRepository for the given Entity
     *
     * @param  string $repository_name EntityRepository name in Bundle:Entity format
     *
     * @return Doctrine\ORM\EntityRepository
     */
    public function getRepository($repository_name)
    {
        return $this->getDoctrine()->getRepository($repository_name);
    }


    /**
     * Shortcut to check whether user has access to a particular role
     *
     * @param string $role
     *
     * @return boolean
     */
    protected function isGranted($role, $entity = null)
    {
        $securityContext = $this->get('security.context');
        return ( $securityContext->isGranted('ROLE_ADMIN') || $securityContext->isGranted($role, $entity) );
    }
}
