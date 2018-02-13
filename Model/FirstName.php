<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Model;

use LIN3S\SharedKernel\Exception\Exception;

class FirstName
{
    private $firstName;

    public function __construct(string $fistName)
    {
        try {
            $this->saveFirstName($fistName);
        } catch (Exception $e) {

        }
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    protected function saveFirstName(string $firstName): void
    {
        if(empty($firstName)){
            throw new Exception("First name is empty");
        }
        $this->firstName = $firstName;
    }

}