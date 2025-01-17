<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type DeprecationSchema from Deprecation
 *
 * @phpstan-type ServerIsoSchema array{
 *     architecture: string,
 *     deprecation?: ?DeprecationSchema,
 *     description: string,
 *     id: int,
 *     name: string,
 *     type: string
 * }
 *
 * @implements ResponseContract<ServerIsoSchema>
 */
final readonly class ServerIso implements ResponseContract
{
    /**
     * @use ArrayAccessible<ServerIsoSchema>
     */
    use ArrayAccessible;

    public function __construct(
        public string $architecture,
        public ?Deprecation $deprecation,
        public string $description,
        public int $id,
        public string $name,
        public string $type,
    ) {}

    /**
     * @param  ServerIsoSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['architecture'],
            isset($attributes['deprecation']) ? Deprecation::from($attributes['deprecation']) : null,
            $attributes['description'],
            $attributes['id'],
            $attributes['name'],
            $attributes['type']
        );
    }

    public function toArray(): array
    {
        return [
            'architecture' => $this->architecture,
            'deprecation' => $this->deprecation?->toArray(),
            'description' => $this->description,
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
