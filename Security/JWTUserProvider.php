<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Security;

use Fiser\MicroservicesInternalAuthenticationBundle\Model\AnonymousUser;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\APISessionErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JWTUserProvider implements UserProviderInterface
{
    private $client;
    private $container;
    private $responseProcessor;

    public function __construct(
        Client $client,
        ContainerInterface $container,
        JWTResponseProcessorInterface $responseProcessor
    )
    {
        $this->client = $client;
        $this->container = $container;
        $this->responseProcessor = $responseProcessor;
    }

    public function loadUserByUsername($jwt): ?UserInterface
    {
        try {
            try {
                $response = $this->client->request(
                    'GET',
                    $this->container->getParameter('uri-authentication'),
                    [
                        'headers' => $this->container->getParameter('headers'),
                        'query' => ['jwt' => $jwt]
                    ]
                );
            } catch (ClientException $exception) {
                throw new APISessionErrorException(
                    $exception->getMessage(),
                    400
                );
            }

            if ($response->getStatusCode() !== 200) {
                throw new APISessionErrorException(
                    $response->getBody()->getContents(),
                    $response->getStatusCode()
                );
            }

            $response = json_decode($response->getBody()->getContents(), true);
            $response['jwt'] = $jwt;
            $user = $this->responseProcessor->process($response);

        } catch (APISessionErrorException $exception) {
            return null;
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): ?UserInterface
    {
        if (!get_class($user) === $this->responseProcessor->supportClass()) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }
        if($user instanceof AnonymousUser) {
            return $user;
        }
        return $this->loadUserByUsername($user->jwt());
    }

    public function supportsClass($class): string
    {
        return $this->responseProcessor->supportClass();
    }
}