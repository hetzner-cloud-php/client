<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Servers;

use HetznerCloud\HttpClientUtilities\Testing\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\PaginationFixture;

use function Pest\Faker\fake;

final class GetServersFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'meta' => PaginationFixture::data(),
            'servers' => array_map(
                static fn () => GetServerFixture::data()['server'],
                range(1, fake()->numberBetween(1, 5))
            ),
        ];
    }
}
