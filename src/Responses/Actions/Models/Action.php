<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Actions\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type ActionSchema array{
 *     command: string,
 *     error: ?array{
 *         code: string,
 *         message: string
 *     },
 *     finished: ?string,
 *     id: int,
 *     progress: int,
 *     resources: array<int, array{
 *          id: int,
 *          type: string
 *     }>,
 *     started: string,
 *     status: string
 * }
 *
 * @implements ResponseContract<ActionSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class Action implements ResponseContract
{
    /**
     * @use ArrayAccessible<ActionSchema>
     */
    use ArrayAccessible;

    public int $id;

    public string $command;

    /** @var null|array{code: string, message: string} */
    public ?array $error;

    public ?string $finished;

    public string $started;

    public string $status;

    public int $progress;

    /** @var array<int, array{id: int, type: string}> */
    public array $resources;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'command' => $this->command,
            'error' => $this->error,
            'finished' => $this->finished,
            'started' => $this->started,
            'status' => $this->status,
            'progress' => $this->progress,
            'resources' => $this->resources,
        ];
    }
}
