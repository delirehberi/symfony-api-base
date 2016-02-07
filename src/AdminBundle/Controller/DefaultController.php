<?php

namespace AdminBundle\Controller;

use CoreBundle\Controller\BaseController;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * @package AdminBundle\Controller
 * @Route(service="controller.admin.default")
 */
class DefaultController extends BaseController
{
    /**
     * @return string
     * @Route("/", name="dashboard")
     */
    public function dashboardAction()
    {
        return $this->success(["Durum" => "Naber"]);
    }

    /**
     * @inheritDoc
     */
    protected function getRepository()
    {
        // TODO: Implement getRepository() method.
    }

}
