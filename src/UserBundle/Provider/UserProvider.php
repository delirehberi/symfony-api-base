<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 7.02.2016
 * Time: 17:04
 */

namespace UserBundle\Provider;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Entity\User;

class UserProvider implements UserProviderInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function loadUserByUsername($username)
    {
        // loadfromdb
        $userRepo = $this->em->getRepository("UserBundle:User");
        $user = $userRepo->getUser($username);

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