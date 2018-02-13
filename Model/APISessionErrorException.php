<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Model;

use LIN3S\SharedKernel\Exception\DomainException;
use Throwable;

class APISessionErrorException extends DomainException
{
    private $statusCode;

    public function __construct(
        string $message = "",
        int $statusCode = 400,
        int $code = 0,
        Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->statusCode = $statusCode;
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }
}