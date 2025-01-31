<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Servers;

use HetznerCloud\Responses\Servers\GetServersResponse;
use HetznerCloud\Testing\Fixtures\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\PaginationFixture;

use function Pest\Faker\fake;

/**
 * @phpstan-import-type GetServersResponseSchema from GetServersResponse
 */
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
                static fn () => GetServerFixture::data()['server'],
                range(1, fake()->numberBetween(1, 5))
            ),
        ];
    }
}
