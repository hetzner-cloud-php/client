<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type TimeSeriesSchema array{
 *     values: array<int, array{0: int, 1: string}>
 * }
 *
 * @implements ResponseContract<TimeSeriesSchema>
 */
final readonly class TimeSeries implements ResponseContract
{
    /**
     * @use ArrayAccessible<TimeSeriesSchema>
     */
    use ArrayAccessible;

    /**
     * @param  array<int, array{0: int, 1: string}>  $values
     */
    public function __construct(
        public array $values
    ) {}

    /**
     * @param  TimeSeriesSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['values'],
        );
    }

    public function toArray(): array
    {
        return [
            'values' => $this->values,
        ];
    }
}
