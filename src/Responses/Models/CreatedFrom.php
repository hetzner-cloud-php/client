<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type CreatedFromSchema array{id: int, name: string}
 *
 * @implements ResponseContract<CreatedFromSchema>
 */
final readonly class CreatedFrom implements ResponseContract
{
    /**
     * @use ArrayAccessible<CreatedFromSchema>
     */
    use ArrayAccessible;

    public function __construct(
        public int $id,
        public string $name,
    ) {}

    /**
     * @param  CreatedFromSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['id'],
            $attributes['name'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
