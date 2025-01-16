<?php

declare(strict_types=1);

namespace HetznerCloud\ValueObjects\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type ProtectionSchema array{delete: bool, rebuild?: bool}
 *
 * @implements ResponseContract<ProtectionSchema>
 */
final readonly class Protection implements ResponseContract
{
    /**
     * @use ArrayAccessible<ProtectionSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public bool $delete,
        public bool $rebuild = false,
    ) {}

    /**
     * @param  ProtectionSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['delete'],
            $attributes['rebuild'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'delete' => $this->delete,
            'rebuild' => $this->rebuild,
        ];
    }
}
