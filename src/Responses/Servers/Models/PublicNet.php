<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
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
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class PublicNet implements ResponseContract
{
    /**
     * @use ArrayAccessible<PublicNetSchema>
     */
    use ArrayAccessible;

    /** @var array<int, array{id: int, status: string}> */
    public array $firewalls;

    /** @var array<int, int> */
    public array $floatingIps;

    public PublicNetIp $ipv4;

    public PublicNetIp $ipv6;

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
