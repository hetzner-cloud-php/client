<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use Override;

/**
 * @phpstan-import-type ActionSchema from Action
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 *
 * @phpstan-type DeleteServerResponseSchema array{
 *     action: ActionSchema
 * }|ErrorResponseSchema
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
        public ?Action $action,
        public ?Error $error,
    ) {
        //
    }

    /**
     * @param  DeleteServerResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['action']) ? Action::from($attributes['action']) : null,
            isset($attributes['error']) ? Error::from($attributes['error']) : null,
        );
    }

    /**
     * {@inheritDoc}
     */
    #[Override]
    public function toArray(): array
    {
        return [
            'action' => $this->action?->toArray(),
            'error' => $this->error?->toArray(),
        ];
    }
}
