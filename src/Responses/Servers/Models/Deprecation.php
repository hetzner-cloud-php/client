<?php

declare(strict_types=1);

namespace HetznerCloud\Responses\Servers\Models;

use Crell\Serde\Attributes as Serde;
use Crell\Serde\Renaming\Cases;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Responses\Concerns\ArrayAccessible;

/**
 * @phpstan-type DeprecationSchema array{announced: string, unavailable_after: string}
 *
 * @implements ResponseContract<DeprecationSchema>
 */
#[Serde\ClassSettings(renameWith: Cases::snake_case)]
final class Deprecation implements ResponseContract
{
    /**
     * @use ArrayAccessible<DeprecationSchema>
     */
    use ArrayAccessible;

    public string $announced;

    public string $unavailableAfter;

    public function toArray(): array
    {
        return [
            'announced' => $this->announced,
            'unavailable_after' => $this->unavailableAfter,
        ];
    }
}
