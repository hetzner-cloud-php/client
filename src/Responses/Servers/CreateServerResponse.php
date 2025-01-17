<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Servers\Models\Server;
use Override;

/**
 * @phpstan-import-type ActionSchema from Action
 * @phpstan-import-type ServerSchema from Server
 *
 * @phpstan-type CreateServerResponseSchema array{
 *     action: ActionSchema,
 *     next_actions: ActionSchema[],
 *     root_password: string,
 *     server: ServerSchema
 * }
 *
 * @implements ResponseContract<CreateServerResponseSchema>
 */
final readonly class CreateServerResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<CreateServerResponseSchema>
     */
    use ArrayAccessible;

    /**
     * @param  Action[]  $nextActions
     */
    private function __construct(
        public Action $action,
        public array $nextActions,
        public string $rootPassword,
        public Server $server,
    ) {
        //
    }

    /**
     * @param  CreateServerResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            Action::from($attributes['action']),
            array_map(fn (array $action): Action => Action::from($action), $attributes['next_actions']),
            $attributes['root_password'],
            Server::from($attributes['server']),
        );
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'action' => $this->action->toArray(),
            'next_actions' => array_map(fn (Action $action): array => $action->toArray(), $this->nextActions),
            'root_password' => $this->rootPassword,
            'server' => $this->server->toArray(),
        ];
    }
}
