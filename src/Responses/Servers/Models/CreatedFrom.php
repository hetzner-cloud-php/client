<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type CreatedFromSchema array{id: int, name: string}
 *
 * @implements ResponseContract<CreatedFromSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class CreatedFrom implements ResponseContract
{
    /**
     * @use ArrayAccessible<CreatedFromSchema>
     */
    use ArrayAccessible;

    public int $id;

    public string $name;

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
