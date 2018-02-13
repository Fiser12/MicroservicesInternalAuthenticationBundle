<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Model;

class User implements UserInterface
{
    private $facebookId;
    private $userEmail;
    private $fullName;
    private $jwt;

    public function __construct(
        UserFacebookId $facebookId,
        UserEmail $userEmail,
        FullName $fullName,
        string $jwt
    )
    {
        $this->facebookId = $facebookId;
        $this->userEmail = $userEmail;
        $this->fullName = $fullName;
        $this->jwt = $jwt;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return;
    }

    public function getSalt()
    {
        return;
    }

    public function getUsername()
    {
        return $this->userEmail->email();
    }

    public function eraseCredentials()
    {
        return;
    }

    public function facebookId(): UserFacebookId
    {
        return $this->facebookId;
    }

    public function email(): UserEmail
    {
        return $this->userEmail;
    }

    public function fullName(): FullName
    {
        return $this->fullName;
    }

    public function jwt(): string
    {
        return $this->jwt;
    }

}
