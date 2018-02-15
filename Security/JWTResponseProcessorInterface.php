<?php

namespace Fiser\MicroservicesInternalAuthenticationBundle\Security;


use Symfony\Component\Security\Core\User\UserInterface;

interface JWTResponseProcessorInterface
{
    public function process(array $response) : UserInterface;

    public function supportClass() : string;
}