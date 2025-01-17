<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Actions\Models\Action;
use Override;

/**
 * @phpstan-import-type ActionSchema from Action
 *
 * @phpstan-type DeleteServerResponseSchema array{action: ActionSchema}
 *
 * @implements ResponseContract<DeleteServerResponseSchema>
 */
final readonly class DeleteServerResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<DeleteServerResponseSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public Action $action,
    ) {
        //
    }

    /**
     * @param  DeleteServerResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            Action::from($attributes['action']),
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
        ];
    }
}
