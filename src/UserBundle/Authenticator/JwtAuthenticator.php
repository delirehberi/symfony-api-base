<?php
/**
 * Created by IntelliJ IDEA.
 * User: emreyilmaz
 * Date: 7.02.2016
 * Time: 17:26
 */

namespace UserBundle\Authenticator;


use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoder;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtAuthenticator extends AbstractGuardAuthenticator
{
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var JWTEncoder
     */
    private $encoder;

    public function __construct(EntityManager $em, JWTEncoder $JWTEncoder)
    {
        $this->em = $em;
        $this->encoder = $JWTEncoder;
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request)
    {
        $extractor = new AuthorizationHeaderTokenExtractor('Bearer', 'Authorization');

        $token = $extractor->extract($request);

        if (false === $token) {
            return null;
        }
        return $token;
    }

    /**
     * @inheritDoc
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $data = $this->encoder->decode($credentials);

        if (!$data) {
            return null;
        }

        $username = $data['username'];

        return $this->em->getRepository('UserBundle:User')->getUser($username);
    }

    /**
     * @inheritDoc
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse(['message' => "Authentication failure!", 401]);
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return;
    }

    /**
     * @inheritDoc
     */
    public function supportsRememberMe()
    {
        // TODO: Implement supportsRememberMe() method.
    }

    /**
     * @inheritDoc
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse([
            'message' => $authException ? $authException->getMessage() : "Access denied"
        ], 401);
    }

}