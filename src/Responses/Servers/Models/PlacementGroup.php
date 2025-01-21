<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type PlacementGroupSchema array{created: string, id: int, labels: array<string, string>, name: string, servers: array<int, int>, type: string}
 *
 * @implements ResponseContract<PlacementGroupSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class PlacementGroup implements ResponseContract
{
    /**
     * @use ArrayAccessible<PlacementGroupSchema>
     */
    use ArrayAccessible;

    public string $created;

    public int $id;

    /** @var array<string, string> */
    public array $labels;

    public string $name;

    /** @var array<int, int> */
    public array $servers;

    public string $type;

    public function toArray(): array
    {
        return [
            'created' => $this->created,
            'id' => $this->id,
            'labels' => $this->labels,
            'name' => $this->name,
            'servers' => $this->servers,
            'type' => $this->type,
        ];
    }
}
