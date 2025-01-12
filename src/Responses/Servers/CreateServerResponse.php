<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use Override;

/**
 * @phpstan-import-type GetServerResponseSchema from GetServerResponse
 *
 * @phpstan-type Action array{
 *   command: string,
 *   error: array{
 *     code: string,
 *     message: string
 *   }|null,
 *   finished: string|null,
 *   id: positive-int,
 *   progress: int<0, 100>,
 *   resources: array<int, array{
 *     id: positive-int,
 *     type: string
 *   }>,
 *   started: string,
 *   status: string
 * }
 * @phpstan-type ServerType array{
 *   architecture: string,
 *   cores: positive-int,
 *   cpu_type: string,
 *   deprecated: bool,
 *   description: string,
 *   disk: positive-int,
 *   id: positive-int,
 *   memory: positive-int,
 *   name: string,
 *   prices: array<int, array{
 *     included_traffic: positive-int,
 *     location: string,
 *     price_hourly: array{
 *       gross: string,
 *       net: string
 *     },
 *     price_monthly: array{
 *       gross: string,
 *       net: string
 *     },
 *     price_per_tb_traffic: array{
 *       gross: string,
 *       net: string
 *     }
 *   }>,
 *   storage_type: string
 * }
 * @phpstan-type CreateServerResponseSchema array{
 *   action: Action,
 *   next_actions: array<int, Action>,
 *   root_password: string,
 *   server: GetServerResponseSchema['server']
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
     * @param  CreateServerResponseSchema['action']  $action
     * @param  CreateServerResponseSchema['next_actions']  $nextActions
     * @param  GetServerResponseSchema['server']  $server
     */
    private function __construct(
        public array $action,
        public array $nextActions,
        public string $rootPassword,
        public array $server,
    ) {
        //
    }

    /**
     * @param  CreateServerResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['action'],
            $attributes['next_actions'],
            $attributes['root_password'],
            $attributes['server'],
        );
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'action' => $this->action,
            'next_actions' => $this->nextActions,
            'root_password' => $this->rootPassword,
            'server' => $this->server,
        ];
    }
}
