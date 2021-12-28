<?php

namespace Syw\Front\MainBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent as FormEvent;
use FOS\UserBundle\Event\UserEvent as UserEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Syw\Front\ApiBundle\Entity\ApiAccess;

/**
 * Class LoginListener
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class LoginListener implements EventSubscriberInterface
{
    private $router;

    /** @var \Symfony\Component\Security\Core\SecurityContext */
    private $securityContext;

    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    private $container;

    public function __construct(ContainerInterface $container, UrlGeneratorInterface $router, SecurityContext $securityContext, Doctrine $doctrine)
    {
        $this->router          = $router;
        $this->securityContext = $securityContext;
        $this->em              = $doctrine->getManager();
        $this->container       = $container;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'onSecurityImplicitLogin',
        );
    }

    public function onSecurityImplicitLogin($event)
    {
        $class = get_class($event);
        if ($class != 'FOS\UserBundle\Event\UserEvent') {
            $url  = $this->router->generate('fos_user_profile_show');
            $user = $event->getAuthenticationToken()->getUser();
            $obj  = $this->em->getRepository('SywFrontApiBundle:ApiAccess')->findOneBy(array("user" => $user));
            if (false === isset($obj) || false === is_object($obj) || $obj == null) {
                $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $apikey           = '';
                for ($i = 0; $i < 48; $i++) {
                    $apikey .= $characters[rand(0, $charactersLength - 1)];
                }
                $apikey    = md5($apikey);
                $ApiAccess = new ApiAccess();
                $ApiAccess->setUser($user);
                $ApiAccess->setApiKey($apikey);
                $this->em->persist($ApiAccess);
                $this->em->flush();
            }
            $this->container->get('session')->getFlashBag()->add('success', 'You have successfully logged in.');
            $event->setResponse(new RedirectResponse($url));
        }
    }

    public function onSecurityInteractivelogin(InteractiveLoginEvent $event)
    {
        $url = $this->router->generate('fos_user_profile_show');

        $user = $event->getAuthenticationToken()->getUser();
        $obj = $this->em->getRepository('SywFrontApiBundle:ApiAccess')->findOneBy(array("user" => $user));
        if (false === isset($obj) || false === is_object($obj) || $obj == null) {
            $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $apikey           = '';
            for ($i = 0; $i < 48; $i++) {
                $apikey .= $characters[rand(0, $charactersLength - 1)];
            }
            $apikey    = md5($apikey);
            $ApiAccess = new ApiAccess();
            $ApiAccess->setUser($user);
            $ApiAccess->setApiKey($apikey);
            $this->em->persist($ApiAccess);
            $this->em->flush();
        }
        $this->container->get('session')->getFlashBag()->add('success', 'You have successfully logged in.');
        $response = new RedirectResponse($url);
        return $response;
    }
}
