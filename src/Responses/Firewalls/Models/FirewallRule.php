<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Firewalls\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type FirewallRuleSchema array{
 *     description: ?string,
 *     destination_ips: string[],
 *     direction: string,
 *     port: ?string,
 *     protocol: ?string,
 *     source_ips: string[],
 * }
 *
 * @implements ResponseContract<FirewallRuleSchema>
 */
final readonly class FirewallRule implements ResponseContract
{
    /**
     * @use ArrayAccessible<FirewallRuleSchema>
     */
    use ArrayAccessible;

    /**
     * @param  string[]  $destinationIps
     * @param  string[]  $source_ips
     */
    private function __construct(
        public ?string $description,
        public array $destinationIps,
        public string $direction,
        public ?string $port,
        public ?string $protocol,
        public array $source_ips
    ) {}

    /**
     * @param  FirewallRuleSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['description'] ?? null,
            $attributes['destination_ips'],
            $attributes['direction'],
            $attributes['port'] ?? null,
            $attributes['protocol'] ?? null,
            $attributes['source_ips']
        );
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'destination_ips' => $this->destinationIps,
            'direction' => $this->direction,
            'port' => $this->port,
            'protocol' => $this->protocol,
            'source_ips' => $this->source_ips,
        ];
    }
}
