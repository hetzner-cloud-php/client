<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Concerns\HasMeta;
use HetznerCloud\Responses\Meta;
use HetznerCloud\Responses\Servers\Models\Server;
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

    use HasMeta;

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
        $servers = array_map(
            static fn (array $server): Server => Server::from($server),
            $attributes['servers']
        );

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
            'servers' => array_map(
                static fn (Server $server): array => $server->toArray(),
                $this->servers
            ),
        ];
    }
}
