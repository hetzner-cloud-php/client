<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Models;

use Carbon\CarbonImmutable;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type PlacementGroupSchema array{created: string, id: int, labels: array<string, string>, name: string, servers: array<int, int>, type: string}
 *
 * @implements ResponseContract<PlacementGroupSchema>
 */
final readonly class PlacementGroup implements ResponseContract
{
    /**
     * @use ArrayAccessible<PlacementGroupSchema>
     */
    use ArrayAccessible;

    /**
     * @param  array<string, string>  $labels
     * @param  array<int, int>  $servers
     */
    public function __construct(
        public CarbonImmutable $created,
        public int $id,
        public array $labels,
        public string $name,
        public array $servers,
        public string $type,
    ) {}

    /**
     * @param  PlacementGroupSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            CarbonImmutable::parse($attributes['created']),
            $attributes['id'],
            $attributes['labels'],
            $attributes['name'],
            $attributes['servers'],
            $attributes['type'],
        );
    }

    public function toArray(): array
    {
        return [
            'created' => $this->created->toIso8601String(),
            'id' => $this->id,
            'labels' => $this->labels,
            'name' => $this->name,
            'servers' => $this->servers,
            'type' => $this->type,
        ];
    }
}
