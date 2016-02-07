<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 7.02.2016
 * Time: 17:04
 */

namespace UserBundle\Provider;


use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\User;

class UserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        // loadfromdb
        $user = new User();
        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        return $user;
    }

    public function supportsClass($class)
    {
        return $class == 'UserBundle\Entity\User';
    }


}