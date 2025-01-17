<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Servers\Models\Server;
use Override;

/**
 * @phpstan-import-type ServerSchema from Server
 *
 * @phpstan-type GetServerResponseSchema array{server: ServerSchema}
 *
 * @implements ResponseContract<GetServerResponseSchema>
 */
final readonly class GetServerResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetServerResponseSchema>
     */
    use ArrayAccessible;

    private function __construct(public Server $server)
    {
        //
    }

    /**
     * @param  GetServerResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(Server::from($attributes['server']));
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'server' => $this->server->toArray(),
        ];
    }
}
