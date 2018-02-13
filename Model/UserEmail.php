<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Model;

class UserEmail
{
    private $email;
    private $domain;
    private $localPart;

    public function __construct($anEmail)
    {
        if (!filter_var($anEmail, FILTER_VALIDATE_EMAIL)) {
            throw new UserEmailInvalidException();
        }
        $this->email = $anEmail;
        $this->localPart = implode(explode('@', $this->email, -1), '@');
        $this->domain = str_replace($this->localPart . '@', '', $this->email);
    }

    public function email()
    {
        return $this->email;
    }

    public function localPart()
    {
        return $this->localPart;
    }

    public function domain()
    {
        return $this->domain;
    }

    public function equals(UserEmail $anEmail)
    {
        return strtolower((string) $this) === strtolower((string) $anEmail);
    }

    public function __toString()
    {
        return $this->email;
    }
}