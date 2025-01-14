<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use Override;

/**
 * @phpstan-type GetServerMetricsResponseSchema array{
 *     metrics: array{
 *         start: string,
 *         end: string,
 *         step: float,
 *         time_series: array<array-key, mixed>
 *     }
 * }
 *
 * @implements ResponseContract<GetServerMetricsResponseSchema>
 */
final readonly class GetServerMetricsResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetServerMetricsResponseSchema>
     */
    use ArrayAccessible;

    /**
     * @param  GetServerMetricsResponseSchema['metrics']  $metrics
     */
    private function __construct(
        public array $metrics,
    ) {
        //
    }

    /**
     * @param  GetServerMetricsResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['metrics'],
        );
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'metrics' => $this->metrics,
        ];
    }
}
