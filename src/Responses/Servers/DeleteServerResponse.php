<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use Override;

/**
 * @phpstan-import-type Action from CreateServerResponse
 *
 * @implements ResponseContract<array{action: Action}>
 */
final readonly class DeleteServerResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{action: Action}>
     */
    use ArrayAccessible;

    /**
     * @param  Action  $action
     */
    private function __construct(
        public array $action,
    ) {
        //
    }

    /**
     * @param  array{action: Action}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['action'],
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
        ];
    }
}
