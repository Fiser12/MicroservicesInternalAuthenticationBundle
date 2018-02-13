<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Model;

class LastName
{
    private $lastName;

    public function __construct(string $lastName)
    {
        $this->saveLastName($lastName);
    }

    public function lastName() : string
    {
        return $this->lastName;
    }

    protected function saveLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
