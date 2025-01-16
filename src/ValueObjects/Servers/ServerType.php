<?php

declare(strict_types=1);

namespace HetznerCloud\ValueObjects\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type DeprecationSchema from Deprecation
 * @phpstan-import-type PriceSchema from Price
 *
 * @phpstan-type ServerTypeSchema array{
 *     architecture: string,
 *     cores: int,
 *     cpu_type: string,
 *     deprecated: bool,
 *     deprecation?: ?DeprecationSchema,
 *     description: string,
 *     disk: int,
 *     id: int,
 *     memory: int,
 *     name: string,
 *     prices: PriceSchema[],
 *     storage_type: string
 * }
 *
 * @implements ResponseContract<ServerTypeSchema>
 */
final readonly class ServerType implements ResponseContract
{
    /**
     * @use ArrayAccessible<ServerTypeSchema>
     */
    use ArrayAccessible;

    /**
     * @param  PriceSchema[]  $prices
     */
    public function __construct(
        public string $architecture,
        public int $cores,
        public string $cpuType,
        public bool $deprecated,
        public ?Deprecation $deprecation,
        public string $description,
        public int $disk,
        public int $id,
        public int $memory,
        public string $name,
        public array $prices,
        public string $storageType,
    ) {}

    /**
     * @param  ServerTypeSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['architecture'],
            $attributes['cores'],
            $attributes['cpu_type'],
            $attributes['deprecated'],
            isset($attributes['deprecation']) ? Deprecation::from($attributes['deprecation']) : null,
            $attributes['description'],
            $attributes['disk'],
            $attributes['id'],
            $attributes['memory'],
            $attributes['name'],
            $attributes['prices'],
            $attributes['storage_type'],
        );
    }

    public function toArray(): array
    {
        return [
            'architecture' => $this->architecture,
            'cores' => $this->cores,
            'cpu_type' => $this->cpuType,
            'deprecated' => $this->deprecated,
            'deprecation' => $this->deprecation?->toArray(),
            'description' => $this->description,
            'disk' => $this->disk,
            'id' => $this->id,
            'memory' => $this->memory,
            'name' => $this->name,
            'prices' => $this->prices,
            'storage_type' => $this->storageType,
        ];
    }
}
