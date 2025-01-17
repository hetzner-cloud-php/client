<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Errors;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type ErrorDetailSchema array{
 *     name: string,
 *     messages: ?string[],
 * }
 *
 * @implements ResponseContract<ErrorDetailSchema>
 */
final readonly class ErrorDetail implements ResponseContract
{
    /**
     * @use ArrayAccessible<ErrorDetailSchema>
     */
    use ArrayAccessible;

    /**
     * @param  string[]|null  $message
     */
    public function __construct(
        public string $name,
        public ?array $message,
    ) {
        //
    }

    /**
     * @param  ErrorDetailSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['name'],
            $attributes['messages'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'messages' => $this->message,
        ];
    }
}
