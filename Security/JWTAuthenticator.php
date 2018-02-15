<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Security;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JWTAuthenticator extends AbstractGuardAuthenticator
{
    private $urlGenerator;
    private $container;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        ContainerInterface $container
    )
    {
        $this->urlGenerator = $urlGenerator;
        $this->container = $container;
    }

    public function supports(Request $request)
    {
        return $request->cookies->get($this->container->getParameter('cookie_name')) !== null;
    }

    public function getCredentials(Request $request)
    {
        return array(
            'token' => $request->cookies->get($this->container->getParameter('cookie_name')),
        );
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $apiKey = $credentials['token'];

        if (null === $apiKey) {
            return null;
        }

        return $userProvider->loadUserByUsername($apiKey);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $loginUrl = $this->urlGenerator->generate($this->container->getParameter('redirection'));
        $response = new RedirectResponse($loginUrl);
        $response->headers->clearCookie($this->container->getParameter('cookie_name'));

        return $response;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $loginUrl = $this->urlGenerator->generate($this->container->getParameter('redirection'));

        return new RedirectResponse($loginUrl);
    }

    public function supportsRememberMe()
    {
        return false;
    }
}