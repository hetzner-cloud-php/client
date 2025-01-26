<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Servers;

use HetznerCloud\Testing\Fixtures\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\PaginationFixture;

use function Pest\Faker\fake;

final class GetServersFixture extends AbstractDataFixture
{
    /**
     * @return array<array-key, mixed>
     */
    public static function data(): array
    {
        return [
            'meta' => PaginationFixture::data(),
            'servers' => array_map(
                fn (): array => GetServerFixture::data()['server'],
                range(1, fake()->numberBetween(1, 5))
            ),
        ];
    }
}
