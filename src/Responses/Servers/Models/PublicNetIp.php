<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type PublicNetIpSchema array{
 *     blocked: bool,
 *     dns_ptr: string|array<int, array{dns_ptr: string, ip: string}>,
 *     id: int,
 *     ip: string
 * }
 *
 * @implements ResponseContract<PublicNetIpSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class PublicNetIp implements ResponseContract
{
    /**
     * @use ArrayAccessible<PublicNetIpSchema>
     */
    use ArrayAccessible;

    public bool $blocked;

    /** @var string|array<int, array{dns_ptr: string, ip: string}> */
    public string|array $dnsPtr;

    public int $id;

    public string $ip;

    public function toArray(): array
    {
        return [
            'blocked' => $this->blocked,
            'dns_ptr' => $this->dnsPtr,
            'id' => $this->id,
            'ip' => $this->ip,
        ];
    }
}
