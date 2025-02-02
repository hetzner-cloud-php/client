<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Concerns;

use HetznerCloud\Testing\Fixtures\ErrorFixture;

trait HasErrorFixture
{
    /**
     * @return array<array-key, mixed>
     */
    public static function error(): array
    {
        return [
            'error' => ErrorFixture::data(),
        ];
    }
}
