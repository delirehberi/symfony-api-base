<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 7.02.2016
 * Time: 17:00
 */

namespace UserBundle\Controller;


use CoreBundle\Controller\BaseController;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use UserBundle\Entity\UserRepository;

/**
 * Class SecurityController
 * @package UserBundle\Controller
 * @Route(service="controller.user.security")
 */
class SecurityController extends BaseController
{
    /**
     * @return UserRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository("UserBundle:User");
    }


    /**
     * @Route("/login", name="security_login", methods={"POST"})
     */
    public function login()
    {
        $request = $this->requestStack->getCurrentRequest();
        $username = $request->get("username");
        $password = $request->get("password");

        $user = $this->getRepository()->getUser($username);

        if (null === $user) {
            return $this->error(["User not found"], 401);
        }
        /** @var UserPasswordEncoderInterface $encoder */
        $encoder = $this->container->get('security.password_encoder');
        if ($user->getPassword() === $encoder->encodePassword($user, $password)) {
            return $this->error(["User not found"], 401);
        }

        $token = $this->container->get('lexik_jwt_authentication.encoder')
            ->encode(['username' => $user->getUsername()]);
        //addrole admin for test.
        //$user->setRoles(['ROLE_ADMIN','ROLE_USER']);
        ///$this->em->persist($user);
        //$this->em->flush();
        return $this->success([
            'token' => $token
        ]);
    }
}