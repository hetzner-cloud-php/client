<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Firewalls\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type ServerResourceSchema from ServerResource
 *
 * @phpstan-type AppliedToResourceSchema array{
 *     type: string,
 *     server: ServerResourceSchema
 * }
 *
 * @implements ResponseContract<AppliedToResourceSchema>
 */
final readonly class AppliedToResource implements ResponseContract
{
    /**
     * @use ArrayAccessible<AppliedToResourceSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public string $type,
        public ServerResource $server
    ) {}

    /**
     * @param  AppliedToResourceSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['type'],
            ServerResource::from($attributes['server'])
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'server' => $this->server->toArray(),
        ];
    }
}
