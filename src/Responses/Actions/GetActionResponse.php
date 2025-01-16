<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Actions;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\ValueObjects\Actions\Action;
use Override;

/**
 * @phpstan-import-type ActionSchema from Action
 *
 * @phpstan-type GetActionResponseSchema array{action: ActionSchema}
 *
 * @implements ResponseContract<GetActionResponseSchema>
 */
final readonly class GetActionResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetActionResponseSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public Action $actions,
    ) {
        //
    }

    /**
     * @param  GetActionResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            Action::from($attributes['action']),
        );
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'action' => $this->actions->toArray(),
        ];
    }
}
