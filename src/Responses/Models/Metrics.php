<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type TimeSeriesSchema from TimeSeries
 *
 * @phpstan-type MetricsSchema array{
 *     start: string,
 *     end: string,
 *     step: float,
 *     time_series: array<string, TimeSeriesSchema>
 * }
 *
 * @implements ResponseContract<MetricsSchema>
 */
final readonly class Metrics implements ResponseContract
{
    /**
     * @use ArrayAccessible<MetricsSchema>
     */
    use ArrayAccessible;

    /**
     * @param  array<string, TimeSeries>  $timeSeries
     */
    public function __construct(
        public string $start,
        public string $end,
        public float $step,
        public array $timeSeries,
    ) {}

    /**
     * @param  MetricsSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['start'],
            $attributes['end'],
            $attributes['step'],
            array_map(
                static fn (array $timeSeries): TimeSeries => TimeSeries::from($timeSeries),
                $attributes['time_series']
            ),
        );
    }

    public function toArray(): array
    {
        return [
            'start' => $this->start,
            'end' => $this->end,
            'step' => $this->step,
            'time_series' => array_map(
                static fn (TimeSeries $timeSeries): array => $timeSeries->toArray(),
                $this->timeSeries
            ),
        ];
    }
}
