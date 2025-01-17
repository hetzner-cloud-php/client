<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Concerns;

use HetznerCloud\Responses\Errors\Error;

/**
 * @property-read ?Error $error
 */
trait HasPotentialError
{
    public function containsDetails(): bool
    {
        return $this->error !== null && $this->error->details !== null;
    }

    public function containsError(): bool
    {
        return $this->error !== null;
    }

    public function error(): ?Error
    {
        return $this->error;
    }
}
