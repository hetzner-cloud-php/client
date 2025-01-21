<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type LocationSchema array{
 *     city: string,
 *     country: string,
 *     description: string,
 *     id: int,
 *     latitude: float,
 *     longitude: float,
 *     name: string,
 *     network_zone: string
 * }
 *
 * @implements ResponseContract<LocationSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class Location implements ResponseContract
{
    /**
     * @use ArrayAccessible<LocationSchema>
     */
    use ArrayAccessible;

    public string $city;

    public string $country;

    public string $description;

    public int $id;

    public float $latitude;

    public float $longitude;

    public string $name;

    public string $networkZone;

    public function toArray(): array
    {
        return [
            'city' => $this->city,
            'country' => $this->country,
            'description' => $this->description,
            'id' => $this->id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'name' => $this->name,
            'network_zone' => $this->networkZone,
        ];
    }
}
