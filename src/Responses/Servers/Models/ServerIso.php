<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-import-type DeprecationSchema from Deprecation
 *
 * @phpstan-type ServerIsoSchema array{
 *     architecture: string,
 *     deprecation?: ?DeprecationSchema,
 *     description: string,
 *     id: int,
 *     name: string,
 *     type: string
 * }
 *
 * @implements ResponseContract<ServerIsoSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class ServerIso implements ResponseContract
{
    /**
     * @use ArrayAccessible<ServerIsoSchema>
     */
    use ArrayAccessible;

    public string $architecture;

    public ?Deprecation $deprecation;

    public string $description;

    public int $id;

    public string $name;

    public string $type;

    public function toArray(): array
    {
        return [
            'architecture' => $this->architecture,
            'deprecation' => $this->deprecation?->toArray(),
            'description' => $this->description,
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}
