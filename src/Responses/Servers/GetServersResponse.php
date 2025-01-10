<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Types\ApiPagination;
use Override;

/**
 * @phpstan-import-type GetServerResponseSchema from GetServerResponse
 *
 * @phpstan-type GetServersResponseSchema array{
 *    meta: array{
 *        pagination: ApiPagination
 *    },
 *    servers: array<int, GetServerResponseSchema['server']>
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
     * @param  GetServersResponseSchema['meta']  $meta
     * @param  GetServersResponseSchema['servers']  $servers
     */
    private function __construct(
        public array $meta,
        public array $servers,
    ) {
        //
    }

    /**
     * @param  GetServersResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['meta'],
            $attributes['servers'],
        );
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'meta' => $this->meta,
            'servers' => $this->servers,
        ];
    }
}
