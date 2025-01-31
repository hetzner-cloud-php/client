<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Resources\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Concerns\HasPotentialError;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use HetznerCloud\Responses\Models\Server;
use Override;

/**
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 * @phpstan-import-type ServerSchema from Server
 *
 * @phpstan-type GetServerResponseSchema array{
 *     server: ?ServerSchema
 * }|ErrorResponseSchema
 *
 * @implements ResponseContract<GetServerResponseSchema>
 */
final readonly class GetServerResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetServerResponseSchema>
     */
    use ArrayAccessible;

    use HasPotentialError;

    private function __construct(
        public ?Server $server,
        public ?Error $error,
    ) {
        //
    }

    /**
     * @param  GetServerResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            server: isset($attributes['server']) ? Server::from($attributes['server']) : null,
            error: isset($attributes['error']) ? Error::from($attributes['error']) : null,
        );
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'server' => $this->server?->toArray(),
            'error' => $this->error?->toArray(),
        ];
    }
}
