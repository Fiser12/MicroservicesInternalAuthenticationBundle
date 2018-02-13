<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Model;

class UserFacebookId
{
    private $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function id() : string
    {
        return $this->id;
    }

    public function equals(UserFacebookId $id) : bool
    {
        return $this->id === $id->id();
    }

}