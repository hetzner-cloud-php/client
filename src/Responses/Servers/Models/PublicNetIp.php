<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

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
final readonly class PublicNetIp implements ResponseContract
{
    /**
     * @use ArrayAccessible<PublicNetIpSchema>
     */
    use ArrayAccessible;

    /**
     * @param  string|array<int, array{dns_ptr: string, ip: string}>  $dnsPtr
     */
    public function __construct(
        public bool $blocked,
        public string|array $dnsPtr,
        public int $id,
        public string $ip,
    ) {}

    /**
     * @param  PublicNetIpSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['blocked'],
            $attributes['dns_ptr'],
            $attributes['id'],
            $attributes['ip'],
        );
    }

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
