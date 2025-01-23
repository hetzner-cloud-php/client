<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Firewalls\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type ServerResourceSchema array{
 *     type: string,
 *     server: array{
 *         id: int
 *     },
 * }
 *
 * @implements ResponseContract<ServerResourceSchema>
 */
final readonly class ServerResource implements ResponseContract
{
    /**
     * @use ArrayAccessible<ServerResourceSchema>
     */
    use ArrayAccessible;

    /**
     * @param  array{id: int}  $server
     */
    private function __construct(
        public string $type,
        public array $server
    ) {}

    /**
     * @param  ServerResourceSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['type'],
            $attributes['server']
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'server' => $this->server,
        ];
    }
}
