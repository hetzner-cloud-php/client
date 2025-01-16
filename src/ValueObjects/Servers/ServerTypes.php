<?php

declare(strict_types=1);

namespace HetznerCloud\ValueObjects\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type ServerTypesSchema array{
 *     available: int[],
 *     available_for_migration: int[],
 *     supported: int[]
 * }
 *
 * @implements ResponseContract<ServerTypesSchema>
 */
final readonly class ServerTypes implements ResponseContract
{
    /**
     * @use ArrayAccessible<ServerTypesSchema>
     */
    use ArrayAccessible;

    /**
     * @param  int[]  $available
     * @param  int[]  $availableForMigration
     * @param  int[]  $supported
     */
    private function __construct(
        public array $available,
        public array $availableForMigration,
        public array $supported,
    ) {}

    /**
     * @param  ServerTypesSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['available'],
            $attributes['available_for_migration'],
            $attributes['supported'],
        );
    }

    public function toArray(): array
    {
        return [
            'available' => $this->available,
            'available_for_migration' => $this->availableForMigration,
            'supported' => $this->supported,
        ];
    }
}
