<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Model;

class FullName
{
    private $firstName;
    private $lastName;

    public function __construct(FirstName $firstName, LastName $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function firstName() : FirstName
    {
        return $this->firstName;
    }

    public function lastName() : LastName
    {
        return $this->lastName;
    }
}