<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type PrivateNetSchema array{
 *     alias_ips: string[],
 *     ip: string,
 *     mac_address: string,
 *     network: int
 * }
 *
 * @implements ResponseContract<PrivateNetSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class PrivateNet implements ResponseContract
{
    /**
     * @use ArrayAccessible<PrivateNetSchema>
     */
    use ArrayAccessible;

    /** @var string[] */
    public array $aliasIps;

    public string $ip;

    public string $macAddress;

    public int $network;

    public function toArray(): array
    {
        return [
            'alias_ips' => $this->aliasIps,
            'ip' => $this->ip,
            'mac_address' => $this->macAddress,
            'network' => $this->network,
        ];
    }
}
