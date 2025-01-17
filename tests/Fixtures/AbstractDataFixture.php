<?php

declare(strict_types=1);

namespace Tests\Fixtures;

abstract class AbstractDataFixture
{
    /**
     * @return array<array-key, mixed>
     */
    abstract public static function data(): array;

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
