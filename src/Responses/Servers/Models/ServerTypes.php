<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
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
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class ServerTypes implements ResponseContract
{
    /**
     * @use ArrayAccessible<ServerTypesSchema>
     */
    use ArrayAccessible;

    /** @var int[] */
    public array $available;

    /** @var int[] */
    public array $availableForMigration;

    /** @var int[] */
    public array $supported;

    public function toArray(): array
    {
        return [
            'available' => $this->available,
            'available_for_migration' => $this->availableForMigration,
            'supported' => $this->supported,
        ];
    }
}
