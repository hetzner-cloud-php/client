<?php

declare(strict_types=1);

namespace HetznerCloud\Exceptions;

use Exception;

final class NotImplementedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Method is not yet implemented.');
    }
}
