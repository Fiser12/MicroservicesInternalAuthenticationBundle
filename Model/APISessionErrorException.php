<?php

declare(strict_types=1);

namespace Fiser\MicroservicesInternalAuthenticationBundle\Model;

use Throwable;

class APISessionErrorException extends \Exception
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