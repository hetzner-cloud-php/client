<?php

declare(strict_types=1);

namespace HetznerCloud\ValueObjects\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type LocationSchema from Location
 * @phpstan-import-type ServerTypesSchema from ServerTypes
 *
 * @phpstan-type DatacenterSchema array{
 *     description?: ?string,
 *     id: int,
 *     location: LocationSchema,
 *     name: string,
 *     server_types: ServerTypesSchema
 * }
 *
 * @implements ResponseContract<DatacenterSchema>
 */
final readonly class Datacenter implements ResponseContract
{
    /**
     * @use ArrayAccessible<DatacenterSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public ?string $description,
        public int $id,
        public Location $location,
        public string $name,
        public ServerTypes $serverTypes,
    ) {}

    /**
     * @param  DatacenterSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['description'] ?? null,
            $attributes['id'],
            Location::from($attributes['location']),
            $attributes['name'],
            ServerTypes::from($attributes['server_types']),
        );
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'id' => $this->id,
            'location' => $this->location->toArray(),
            'name' => $this->name,
            'server_types' => $this->serverTypes->toArray(),
        ];
    }
}
