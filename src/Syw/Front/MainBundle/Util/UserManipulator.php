<?php

namespace Syw\Front\MainBundle\Util;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Syw\Front\MainBundle\Entity\UserProfile;

/**
 *
 */
class UserManipulator
{
    /**
     * User manager
     *
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Creates a user and returns it.
     *
     * @param string  $username
     * @param string  $password
     * @param string  $email
     * @param string  $locale
     * @param Boolean $active
     * @param Boolean $superadmin
     *
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function create($username, $password, $email, $locale, $active, $superadmin)
    {
        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setLocale($locale);
        $user->setPlainPassword($password);
        $user->setEnabled((Boolean)$active);
        $user->setSuperAdmin((Boolean)$superadmin);
        $this->userManager->updateUser($user);

        /*
        $userProfile = new UserProfile();
        $userProfile->setUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($userProfile);
        $em->flush();

        $user->setProfile($userProfile);
        $this->userManager->updateUser($user);
        */

        return $user;
    }

    /**
     * Deletes the given user.
     *
     * @param string $username
     */
    public function delete($username)
    {
        $user = $this->findUserByUsernameOrThrowException($username);
        $this->userManager->deleteUser($user);
    }

    /**
     * Finds a user by his username and throws an exception if we can't find it.
     *
     * @param string $username
     *
     * @throws \InvalidArgumentException When user does not exist
     *
     * @return UserInterface
     */
    private function findUserByUsernameOrThrowException($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('User identified by "%s" username does not exist.', $username));
        }

        return $user;
    }
}
