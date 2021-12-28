<?php

namespace Syw\Front\MainBundle\Tests;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class BaseTestCase
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
abstract class BaseTestCase extends WebTestCase
{
    /**
     * @var Symfony\Component\DependencyInjection\Container
     */
    protected static $container;

    protected static $em;

    protected $form;


    public function getContainer()
    {
        return self::$container;
    }


    public function getManager()
    {
        return self::$em;
    }


    public function get($serviceId)
    {
        return self::$container->get($serviceId);
    }
}
