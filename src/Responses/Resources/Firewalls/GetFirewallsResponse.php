<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Resources\Firewalls;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;
use HetznerCloud\Responses\Models\Firewall;
use HetznerCloud\Responses\Models\Meta;

/**
 * @phpstan-import-type FirewallSchema from Firewall
 * @phpstan-import-type MetaSchema from Meta
 *
 * @phpstan-type GetFirewallsResponseSchema array{
 *     firewalls: FirewallSchema[],
 *     meta: MetaSchema
 * }
 *
 * @implements ResponseContract<GetFirewallsResponseSchema>
 */
final readonly class GetFirewallsResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<GetFirewallsResponseSchema>
     */
    use ArrayAccessible;

    /**
     * @param  Firewall[]  $firewalls
     */
    private function __construct(
        public array $firewalls,
        public Meta $meta,
    ) {}

    /**
     * @param  GetFirewallsResponseSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            array_map(
                static fn (array $firewall): Firewall => Firewall::from($firewall),
                $attributes['firewalls']
            ),
            Meta::from($attributes['meta']),
        );
    }

    public function toArray(): array
    {
        return [
            'firewalls' => array_map(
                static fn (Firewall $firewall): array => $firewall->toArray(),
                $this->firewalls
            ),
            'meta' => $this->meta->toArray(),
        ];
    }
}
