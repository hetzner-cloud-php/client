<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Actions;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\ValueObjects\Actions\Action;
use HetznerCloud\ValueObjects\Meta;
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
            array_map(fn (array $action): \HetznerCloud\ValueObjects\Actions\Action => Action::from($action), $attributes['actions']),
            Meta::from($attributes['meta']),
        );
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'actions' => array_map(fn (Action $action): array => $action->toArray(), $this->actions),
            'meta' => $this->meta->toArray(),
        ];
    }
}
