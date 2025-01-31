<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Models;

use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type AppliedToSchema from AppliedTo
 * @phpstan-import-type FirewallRuleSchema from FirewallRule
 * @phpstan-import-type ServerResourceSchema from ServerResource
 *
 * @phpstan-type FirewallSchema array{
 *     applied_to: AppliedToSchema[],
 *     created: string,
 *     id: int,
 *     labels: array<string, string>,
 *     name: string,
 *     rules: FirewallRuleSchema[],
 * }
 *
 * @implements ResponseContract<FirewallSchema>
 */
final readonly class Firewall implements ResponseContract
{
    /**
     * @use ArrayAccessible<FirewallSchema>
     */
    use ArrayAccessible;

    /**
     * @param  AppliedTo[]  $appliedTo
     * @param  array<string, string>  $labels
     * @param  FirewallRule[]  $rules
     */
    private function __construct(
        public array $appliedTo,
        public string $created,
        public int $id,
        public array $labels,
        public string $name,
        public array $rules
    ) {}

    /**
     * @param  FirewallSchema  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            array_map(fn (array $appliedTo): \HetznerCloud\Responses\Models\AppliedTo => AppliedTo::from($appliedTo), $attributes['applied_to']),
            $attributes['created'],
            $attributes['id'],
            $attributes['labels'],
            $attributes['name'],
            array_map(fn (array $rule): \HetznerCloud\Responses\Models\FirewallRule => FirewallRule::from($rule), $attributes['rules']),
        );
    }

    public function toArray(): array
    {
        return [
            'applied_to' => array_map(
                static fn (AppliedTo $appliedTo): array => $appliedTo->toArray(),
                $this->appliedTo,
            ),
            'created' => $this->created,
            'id' => $this->id,
            'labels' => $this->labels,
            'name' => $this->name,
            'rules' => array_map(
                static fn (FirewallRule $rule): array => $rule->toArray(),
                $this->rules,
            ),
        ];
    }
}
