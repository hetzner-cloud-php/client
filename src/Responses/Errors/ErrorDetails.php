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
final readonly class ErrorDetails implements ResponseContract
{
    /**
     * @use ArrayAccessible<ErrorDetailsSchema>
     */
    use ArrayAccessible;

    /**
     * @param  ErrorDetail[]  $fields
     */
    public function __construct(
        public array $fields,
    ) {
        //
    }

    /**
     * @param  ErrorDetailsSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            array_map(fn (array $detail): \HetznerCloud\Responses\Errors\ErrorDetail => ErrorDetail::from($detail), $attributes['fields']),
        );
    }

    public function toArray(): array
    {
        return [
            'fields' => array_map(fn (ErrorDetail $detail): array => $detail->toArray(), $this->fields),
        ];
    }
}
