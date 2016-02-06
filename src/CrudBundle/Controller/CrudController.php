<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 6.02.2016
 * Time: 01:00
 */

namespace CrudBundle\Controller;


use CoreBundle\Controller\BaseController;
use CrudBundle\Entity\CrudRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class CrudController extends BaseController
{
    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response|static
     * @Route(path="/{id}",requirements={"id"="\d+"},methods={"GET"})
     */
    public function getAction($id)
    {
        $data = $this->getRepository()->getOneById($id);
        return $this->success($data);
    }

    /**
     * @Route(path="/",methods={"GET"})
     * @return JsonResponse
     */
    public function listAction()
    {
        $repository = $this->getRepository();
        $request = $this->requestStack->getCurrentRequest();
        $offset = $request->get('offset', 1);
        $limit = $request->get('limit', null);
        $data = $repository->getAll($offset, $limit);
        return $this->success($data);
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
            $new = $this->serializer->deserialize($json_data, $repository->getClassName(), 'json');
            $new = $this->em->merge($new);
            $this->em->persist($new);
            $this->em->flush();
            return $this->success($new);
        }
        return $this->error(["Beklenmedik hata"]);
    }

    /**
     * @param $id
     * @Route(path="/{id}", requirements={"id"="\d+"},methods={"DELETE"})
     * @return JsonResponse
     */
    public function deleteAction($id)
    {
        $item = $this->getRepository()->find($id);
        if ($item) {
            $this->em->remove($item);
            $this->em->flush();
            return $this->success(["Deleted #$id"]);
        }
        return $this->error(["Not deleted"]);
    }

    /**
     * @return CrudRepository
     */
    protected function getRepository()
    {
        return null;
    }

}