<?php

namespace Fiser\MicroservicesInternalAuthenticationBundle\Security;


use Fiser\MicroservicesInternalAuthenticationBundle\Model\FirstName;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\FullName;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\LastName;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\User;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\UserEmail;
use Fiser\MicroservicesInternalAuthenticationBundle\Model\UserFacebookId;
use Symfony\Component\Security\Core\User\UserInterface;

class JWTResponseProcessor implements JWTResponseProcessorInterface
{
    public function process(array $response): UserInterface
    {
        $user = new User(
            new UserFacebookId($response['user']['id']),
            new UserEmail($response['user']['email']),
            new FullName(
                new FirstName($response['user']['first_name']),
                new LastName($response['user']['last_name'])
            ),
            $response['jwt']
        );
        return $user;
    }

    public function supportClass(): string
    {
        return User::class;
    }
}