<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Firewalls;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Errors\ErrorResponse;
use HetznerCloud\Responses\Firewalls\Models\Firewall;

/**
 * @phpstan-import-type FirewallSchema from Firewall
 * @phpstan-import-type ErrorResponseSchema from ErrorResponse
 *
 * @phpstan-type GetFirewallResponseSchema array{
 *     firewall: ?FirewallSchema
 * }|ErrorResponseSchema
 *
 * @implements ResponseContract<GetFirewallResponseSchema>
 */
final readonly class GetFirewallResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetFirewallResponseSchema>
     */
    use ArrayAccessible;

    private function __construct(
        public ?Firewall $firewall,
        public ?Error $error,
    ) {}

    /**
     * @param  GetFirewallResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['firewall']) ? Firewall::from($attributes['firewall']) : null,
            isset($attributes['error']) ? Error::from($attributes['error']) : null,
        );
    }

    public function toArray(): array
    {
        return [
            'firewall' => $this->firewall?->toArray(),
            'error' => $this->error?->toArray(),
        ];
    }
}
