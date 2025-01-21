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
final class ErrorDetail implements ResponseContract
{
    /**
     * @use ArrayAccessible<ErrorDetailSchema>
     */
    use ArrayAccessible;

    public string $name;

    /** @var string[]|null */
    public ?array $message;

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'messages' => $this->message,
        ];
    }
}
