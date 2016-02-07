<?php

namespace CoreBundle\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class DefaultController
 * @package CoreBundle\Controller
 */
abstract class BaseController extends Controller
{
    /** @var SerializerInterface */
    protected $serializer;
    /** @var EntityManager */
    protected $em;
    /** @var JsonResponse */
    private $jsonResponse;
    /** @var RequestStack */
    protected $requestStack;
    /** @var ContainerInterface */
    protected $container;

    /**
     * DefaultController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        $this->serializer = $this->container->get('jms_serializer');
        $this->jsonResponse = new JsonResponse();
        $this->requestStack = $this->container->get('request_stack');
    }

    /**
     * @param $data
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    protected function success($data, $status = 200, $headers = [])
    {
        $serialized_data = $this->serializer->serialize($data, 'json');
        $response = $this
            ->jsonResponse;
        $response->setContent($serialized_data)
            ->setStatusCode($status)
            ->headers
            ->add($headers);
        return $response;
    }

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response|static
     */
    protected function error(array $data, $status = 500, $headers = [])
    {
        return $this->jsonResponse->create($data, $status, $headers);
    }

    /**
     * @return EntityRepository
     */
    abstract protected function getRepository();
}
