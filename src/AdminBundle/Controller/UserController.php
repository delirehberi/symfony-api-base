<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 7.02.2016
 * Time: 21:46
 */

namespace AdminBundle\Controller;


use CrudBundle\Controller\CrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use UserBundle\Entity\User;

/**
 * Class UserController
 * @package AdminBundle\Controller
 * @Route(service="controller.admin.user",path="/user")
 */
class UserController extends CrudController
{
    /**
     * @Route("/me",methods={"GET"})
     */
    public function meAction()
    {
        $user = $this->getUser();
        return $this->getAction($user->getId());
    }

    /**
     * @inheritdoc
     */
    protected function getRepository()
    {
        return $this->em->getRepository("UserBundle:User");
    }

    /**
     * @Route(path="/",methods={"POST","PUT"})
     * @return JsonResponse
     */
    public function createAction()
    {
        $request = $this->requestStack->getCurrentRequest();
        $json_data = $request->getContent();
        $repository = $this->getRepository();
        if ($json_data) {
            /** @var User $new */
            $new = $this->serializer->deserialize($json_data, $repository->getClassName(), 'json');
            $id = $new->getId();
            $new = $this->em->merge($new);
            /** @var UserPasswordEncoderInterface $encoder */
            $encoder = $this->container->get('security.password_encoder');
            if (!$id) { //@todo
                //check user
                $check = $this->getRepository()->findOneBy(['email' => $new->getEmail()]);
                if ($check) {
                    return $this->error([
                        "User already exists"
                    ]);
                }
                $password = $encoder->encodePassword($new, $new->getPassword());
                $new->setPassword($password);
                $new->refreshSalt();
            } else {
                $user = $this->getRepository()->find($new->getId());
                if ($user->getPassword() != $new->getPassword() && $new->getPassword() != null) {
                    $password = $encoder->encodePassword($new, $new->getPassword());
                    $new->setPassword($password);
                    $new->refreshSalt();
                }
            }
            $this->em->persist($new);
            $this->em->flush();

            return $this->success($new);
        }
        return $this->error(["Yetersiz veri."], 400);
    }
}