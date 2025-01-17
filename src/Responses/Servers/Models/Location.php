<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

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
final readonly class Location implements ResponseContract
{
    /**
     * @use ArrayAccessible<LocationSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public string $city,
        public string $country,
        public string $description,
        public int $id,
        public float $latitude,
        public float $longitude,
        public string $name,
        public string $networkZone,
    ) {}

    /**
     * @param  LocationSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['city'],
            $attributes['country'],
            $attributes['description'],
            $attributes['id'],
            $attributes['latitude'],
            $attributes['longitude'],
            $attributes['name'],
            $attributes['network_zone'],
        );
    }

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
