<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Errors;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type ErrorDetailsSchema from ErrorDetails
 *
 * @phpstan-type ErrorSchema array{
 *     code: string,
 *     message: string,
 *     details: ?ErrorDetailsSchema,
 * }
 *
 * @implements ResponseContract<ErrorSchema>
 */
final readonly class Error implements ResponseContract
{
    /**
     * @use ArrayAccessible<ErrorSchema>
     */
    use ArrayAccessible;

    public function __construct(
        public string $code,
        public string $message,
        public ?ErrorDetails $details,
    ) {
        //
    }

    /**
     * @param  ErrorSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['code'],
            $attributes['message'],
            isset($attributes['details']) ? ErrorDetails::from($attributes['details']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'details' => $this->details?->toArray(),
        ];
    }
}
