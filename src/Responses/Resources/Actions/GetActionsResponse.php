<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Resources\Actions;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Concerns\HasMeta;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Models\Meta;
use Override;

/**
 * @phpstan-import-type MetaSchema from Meta
 * @phpstan-import-type ActionSchema from Action
 *
 * @phpstan-type GetActionsResponseSchema array{
 *     actions: ActionSchema[],
 *     meta: MetaSchema
 * }
 *
 * @implements ResponseContract<GetActionsResponseSchema>
 */
final readonly class GetActionsResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetActionsResponseSchema>
     */
    use ArrayAccessible;

    use HasMeta;

    /**
     * @param  Action[]  $actions
     */
    private function __construct(
        public array $actions,
        public Meta $meta,
    ) {
        //
    }

    /**
     * @param  GetActionsResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            array_map(
                static fn (array $action): \HetznerCloud\Responses\Models\Action => Action::from($action),
                $attributes['actions']
            ),
            Meta::from($attributes['meta']),
        );
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'actions' => array_map(
                static fn (Action $action): array => $action->toArray(),
                $this->actions
            ),
            'meta' => $this->meta->toArray(),
        ];
    }
}
