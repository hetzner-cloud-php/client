<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Errors;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type ErrorSchema from Error
 *
 * @phpstan-type ErrorResponseSchema array{error: ?ErrorSchema}
 *
 * @implements ResponseContract<ErrorResponseSchema>
 */
final readonly class ErrorResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<ErrorResponseSchema>
     */
    use ArrayAccessible;

    public function __construct(
        public Error $error
    ) {
        //
    }

    /**
     * @param  ErrorSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            Error::from($attributes),
        );
    }

    public function toArray(): array
    {
        return [
            'error' => $this->error->toArray(),
        ];
    }
}
