<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Concerns\HasPotentialError;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use HetznerCloud\Responses\Servers\Models\Server;
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
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class CreateServerResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<CreateServerResponseSchema>
     */
    use ArrayAccessible;

    use HasPotentialError;

    public ?Action $action;

    /** @var null|ActionSchema[] */
    public ?array $nextActions;

    public ?string $rootPassword;

    public ?Server $server;

    public ?Error $error;

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
