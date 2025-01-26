<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Concerns\HasPotentialError;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use HetznerCloud\Responses\Servers\Models\Server;
use HetznerCloud\Testing\Responses\Concerns\Fakeable;
use Override;

/**
 * @phpstan-import-type ActionSchema from Action
 * @phpstan-import-type ErrorSchema from Error
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 * @phpstan-import-type ServerSchema from Server
 *
 * @phpstan-type CreateServerResponseSchema array{
 *     action: ?ActionSchema,
 *     next_actions: ?ActionSchema[],
 *     root_password: ?string,
 *     server: ?ServerSchema
 * }|ErrorResponseSchema
 *
 * @implements ResponseContract<CreateServerResponseSchema>
 */
final readonly class CreateServerResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<CreateServerResponseSchema>
     */
    use ArrayAccessible;

    use Fakeable, HasPotentialError;

    /**
     * @param  Action[]  $nextActions
     */
    private function __construct(
        public ?Action $action = null,
        public ?array $nextActions = null,
        public ?string $rootPassword = null,
        public ?Server $server = null,
        public ?Error $error = null,
    ) {
        //
    }

    /**
     * @param  CreateServerResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['action']) ? Action::from($attributes['action']) : null,
            isset($attributes['next_actions']) ? array_map(
                static fn (array $action): Action => Action::from($action),
                $attributes['next_actions']
            ) : null,
            $attributes['root_password'] ?? null,
            isset($attributes['server']) ? Server::from($attributes['server']) : null,
            isset($attributes['error']) ? Error::from($attributes['error']) : null,
        );
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'action' => $this->action?->toArray(),
            'next_actions' => array_map(
                static fn (Action $action): array => $action->toArray(),
                $this->nextActions ?? []
            ),
            'root_password' => $this->rootPassword,
            'server' => $this->server?->toArray(),
            'error' => $this->error?->toArray(),
        ];
    }
}
