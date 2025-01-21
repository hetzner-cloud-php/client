<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type ProtectionSchema array{delete: bool, rebuild?: bool}
 *
 * @implements ResponseContract<ProtectionSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class Protection implements ResponseContract
{
    /**
     * @use ArrayAccessible<ProtectionSchema>
     */
    use ArrayAccessible;

    public bool $delete;

    public ?bool $rebuild;

    public function toArray(): array
    {
        return [
            'delete' => $this->delete,
            'rebuild' => $this->rebuild,
        ];
    }
}
