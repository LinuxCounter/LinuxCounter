<?php

namespace Syw\Front\MainBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class PasswordResettingListener
 *
 * @author Christin Löhner <alex.loehner@linux.com>
 */
class FormSuccessListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => array('onFormSuccess', -10),
            FOSUserEvents::CHANGE_PASSWORD_SUCCESS => array('onFormSuccess', -10),
            FOSUserEvents::PROFILE_EDIT_SUCCESS => array('onFormSuccess', -10),
        );
    }

    public function onFormSuccess(FormEvent $event)
    {
        $url = $this->router->generate('syw_front_main_main_index');

        if ($event == FOSUserEvents::REGISTRATION_SUCCESS) {
            $this->get('session')->getFlashBag()->add('success', 'Your registration was successful. An email was sent to your postbox. Please check it and click the confirmation link.');
        }

        $event->setResponse(new RedirectResponse($url));
    }
}
