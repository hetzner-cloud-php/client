<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Errors;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type ErrorDetailSchema from ErrorDetail
 *
 * @phpstan-type ErrorDetailsSchema array{fields: ErrorDetailSchema[]}
 *
 * @implements ResponseContract<ErrorDetailsSchema>
 */
final class ErrorDetails implements ResponseContract
{
    /**
     * @use ArrayAccessible<ErrorDetailsSchema>
     */
    use ArrayAccessible;

    /** @var ErrorDetailSchema[] */
    public array $fields;

    public function toArray(): array
    {
        return [
            'fields' => array_map(fn (ErrorDetail $detail): array => $detail->toArray(), $this->fields),
        ];
    }
}
