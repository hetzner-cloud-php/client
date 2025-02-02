<?php

declare(strict_types=1);

namespace HetznerCloud\Exceptions;

use Exception;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use RuntimeException;

/**
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 */
final class HetznerCloudException extends Exception
{
    public function __construct(
        public readonly Error $error,
        public readonly int $statusCode
    ) {
        parent::__construct($this->error->message);
    }

    /**
     * @param  ErrorResponseSchema  $error
     */
    public static function from(array $error, int $statusCode): self
    {
        if (! isset($error['error'])) {
            throw new RuntimeException('Response error is not set.');
        }

        return new self(
            Error::from($error['error']),
            $statusCode
        );
    }
}
