<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
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
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class Datacenter implements ResponseContract
{
    /**
     * @use ArrayAccessible<DatacenterSchema>
     */
    use ArrayAccessible;

    public ?string $description;

    public int $id;

    public Location $location;

    public string $name;

    public ServerTypes $serverTypes;

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
