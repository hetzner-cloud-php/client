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
final class Error implements ResponseContract
{
    /**
     * @use ArrayAccessible<ErrorSchema>
     */
    use ArrayAccessible;

    public string $code;

    public string $message;

    public ?ErrorDetails $details;

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'details' => $this->details?->toArray(),
        ];
    }
}
