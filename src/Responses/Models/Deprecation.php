<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Models;

use Carbon\CarbonImmutable;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type DeprecationSchema array{announced: string, unavailable_after: string}
 *
 * @implements ResponseContract<DeprecationSchema>
 */
final readonly class Deprecation implements ResponseContract
{
    /**
     * @use ArrayAccessible<DeprecationSchema>
     */
    use ArrayAccessible;

    public function __construct(
        public CarbonImmutable $announced,
        public CarbonImmutable $unavailableAfter,
    ) {}

    /**
     * @param  DeprecationSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            CarbonImmutable::parse($attributes['announced']),
            CarbonImmutable::parse($attributes['unavailable_after'])
        );
    }

    public function toArray(): array
    {
        return [
            'announced' => $this->announced->toIso8601String(),
            'unavailable_after' => $this->unavailableAfter->toIso8601String(),
        ];
    }
}
