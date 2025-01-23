<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Firewalls\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type ServerResourceSchema from ServerResource
 *
 * @phpstan-type AppliedToSchema array{
 *     applied_to_resources: ServerResourceSchema[],
 *     label_selector: array{selector: string},
 *     type: string,
 *     server: array{
 *         id: int
 *     }
 * }
 *
 * @implements ResponseContract<AppliedToSchema>
 */
final readonly class AppliedTo implements ResponseContract
{
    /**
     * @use ArrayAccessible<AppliedToSchema>
     */
    use ArrayAccessible;

    /**
     * @param  ServerResource[]  $appliedToResources
     * @param  array{selector: string}  $labelSelector
     * @param  array{id: int}  $server
     */
    private function __construct(
        public array $appliedToResources,
        public array $labelSelector,
        public string $type,
        public array $server
    ) {}

    /**
     * @param  AppliedToSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            array_map(fn (array $item): \HetznerCloud\Responses\Firewalls\Models\ServerResource => ServerResource::from($attributes), $attributes['applied_to_resources']),
            $attributes['label_selector'],
            $attributes['type'],
            $attributes['server']
        );
    }

    public function toArray(): array
    {
        return [
            'applied_to_resources' => array_map(
                static fn (ServerResource $serverResource): array => $serverResource->toArray(),
                $this->appliedToResources
            ),
            'label_selector' => $this->labelSelector,
            'type' => $this->type,
            'server' => $this->server,
        ];
    }
}
