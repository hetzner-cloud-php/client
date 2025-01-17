<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type PublicNetIpSchema from PublicNetIp
 *
 * @phpstan-type PublicNetSchema array{
 *   firewalls: array<int, array{
 *     id: int,
 *     status: string
 *   }>,
 *   floating_ips: array<int, int>,
 *   ipv4: PublicNetIpSchema,
 *   ipv6: PublicNetIpSchema
 * }
 *
 * @implements ResponseContract<PublicNetSchema>
 */
final readonly class PublicNet implements ResponseContract
{
    /**
     * @use ArrayAccessible<PublicNetSchema>
     */
    use ArrayAccessible;

    /**
     * @param PublicNetSchema['firewalls']  $firewalls
     * @param PublicNetSchema['floating_ips']  $floatingIps
     */
    public function __construct(
        public array $firewalls,
        public array $floatingIps,
        public PublicNetIp $ipv4,
        public PublicNetIp $ipv6,
    ) {}

    /**
     * @param  PublicNetSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['firewalls'],
            $attributes['floating_ips'],
            PublicNetIp::from($attributes['ipv4']),
            PublicNetIp::from($attributes['ipv6']),
        );
    }

    public function toArray(): array
    {
        return [
            'firewalls' => $this->firewalls,
            'floating_ips' => $this->floatingIps,
            'ipv4' => $this->ipv4->toArray(),
            'ipv6' => $this->ipv6->toArray(),
        ];
    }
}
