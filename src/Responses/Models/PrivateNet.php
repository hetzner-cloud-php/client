<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Models;

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
final readonly class PrivateNet implements ResponseContract
{
    /**
     * @use ArrayAccessible<PrivateNetSchema>
     */
    use ArrayAccessible;

    /**
     * @param  string[]  $aliasIps
     */
    public function __construct(
        public array $aliasIps,
        public string $ip,
        public string $macAddress,
        public int $network,
    ) {}

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
