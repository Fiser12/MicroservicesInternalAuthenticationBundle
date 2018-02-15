<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Security;

use Fiser\MicroservicesInternalAuthenticationBundle\Model\APISessionErrorException;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\FirstName;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\FullName;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\LastName;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\User;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\UserEmail;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\UserFacebookId;
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

    public function __construct(Client $client, ContainerInterface $container)
    {
        $this->client = $client;
        $this->container = $container;
    }

    public function loadUserByUsername($jwt): ?User
    {
        try {
            try {
                $response = $this->client->request(
                    'GET',
                    $this->container->getParameter('uri-login-failed'),
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

            $user = new User(
                new UserFacebookId($response['user']['id']),
                new UserEmail($response['user']['email']),
                new FullName(
                    new FirstName($response['user']['first_name']),
                    new LastName($response['user']['last_name'])
                ),
                $jwt
            );

        } catch (APISessionErrorException $exception) {
            return null;
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): ?User
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->jwt());
    }

    public function supportsClass($class): string
    {
        return User::class;
    }
}