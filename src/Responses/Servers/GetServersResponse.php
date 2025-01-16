<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\ValueObjects\Meta;
use HetznerCloud\ValueObjects\Servers\Server;
use Override;

/**
 * @phpstan-import-type ServerSchema from Server
 * @phpstan-import-type MetaSchema from Meta
 *
 * @phpstan-type GetServersResponseSchema array{
 *    meta: MetaSchema,
 *    servers: ServerSchema[]
 *  }
 *
 * @implements ResponseContract<GetServersResponseSchema>
 */
final readonly class GetServersResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetServersResponseSchema>
     */
    use ArrayAccessible;

    /**
     * @param  Server[]  $servers
     */
    private function __construct(
        public Meta $meta,
        public array $servers,
    ) {
        //
    }

    /**
     * @param  GetServersResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        $servers = array_map(fn (array $server): \HetznerCloud\ValueObjects\Servers\Server => Server::from($server), $attributes['servers']);

        return new self(
            Meta::from($attributes['meta']),
            $servers,
        );
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'meta' => $this->meta->toArray(),
            'servers' => array_map(fn (Server $server): array => $server->toArray(), $this->servers),
        ];
    }
}
