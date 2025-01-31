<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Resources\Actions;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use HetznerCloud\Responses\Models\Action;
use Override;

/**
 * @phpstan-import-type ActionSchema from Action
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 *
 * @phpstan-type GetActionResponseSchema array{
 *     action: ?ActionSchema
 * }|ErrorResponseSchema
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
        public ?Action $action,
        public ?Error $error,
    ) {
        //
    }

    /**
     * @param  GetActionResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['action']) ? Action::from($attributes['action']) : null,
            isset($attributes['error']) ? Error::from($attributes['error']) : null,
        );
    }

    #[Override]
    public function toArray(): array
    {
        return [
            'action' => $this->action?->toArray(),
            'error' => $this->error?->toArray(),
        ];
    }
}
