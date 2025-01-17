<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Concerns\HasPotentialError;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use HetznerCloud\Responses\Servers\Models\Metrics;
use Override;

/**
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 * @phpstan-import-type MetricsSchema from Metrics
 *
 * @phpstan-type GetServerMetricsResponseSchema array{
 *     metrics: ?MetricsSchema
 * }|ErrorResponseSchema
 *
 * @implements ResponseContract<GetServerMetricsResponseSchema>
 */
final readonly class GetServerMetricsResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetServerMetricsResponseSchema>
     */
    use ArrayAccessible;

    use HasPotentialError;

    private function __construct(
        public ?Metrics $metrics,
        public ?Error $error,
    ) {
        //
    }

    /**
     * @param  GetServerMetricsResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['metrics']) ? Metrics::from($attributes['metrics']) : null,
            isset($attributes['error']) ? Error::from($attributes['error']) : null,
        );
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'metrics' => $this->metrics?->toArray(),
            'error' => $this->error?->toArray(),
        ];
    }
}
