<?php

namespace UserBundle\Controller;

use CoreBundle\Controller\BaseController;
use CrudBundle\Controller\CrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class DefaultController
 * @package UserBundle\Controller
 * @Route(path="/user",service="controller.user.default")
 */
class DefaultController extends CrudController
{
    /**
     * @inheritdoc
     */
    protected function getRepository()
    {
        return $this->em->getRepository("UserBundle:User");
    }
}
