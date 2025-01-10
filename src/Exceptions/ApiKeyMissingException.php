<?php

declare(strict_types=1);

namespace HetznerCloud\Exceptions;

use Exception;

final class ApiKeyMissingException extends Exception
{
    public function __construct()
    {
        parent::__construct('API key is required to call the Hetzner Cloud API.');
    }
}
