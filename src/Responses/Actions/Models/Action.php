<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Actions\Models;

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
final readonly class Action implements ResponseContract
{
    /**
     * @use ArrayAccessible<ActionSchema>
     */
    use ArrayAccessible;

    /**
     * @param  array{code: string, message: string}|null  $error
     * @param  array<int, array{id: int, type: string}>  $resources
     */
    public function __construct(
        public int $id,
        public string $command,
        public ?array $error,
        public ?string $finished,
        public string $started,
        public string $status,
        public int $progress,
        public array $resources,
    ) {
        //
    }

    /**
     * @param  ActionSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['id'],
            $attributes['command'],
            $attributes['error'],
            $attributes['finished'],
            $attributes['started'],
            $attributes['status'],
            $attributes['progress'],
            $attributes['resources'],
        );
    }

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
