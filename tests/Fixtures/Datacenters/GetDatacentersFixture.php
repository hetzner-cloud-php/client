<?php

declare(strict_types=1);

namespace Tests\Fixtures\Datacenters;

use Tests\Fixtures\AbstractDataFixture;
use Tests\Fixtures\PaginationFixture;

use function Pest\Faker\fake;

final class GetDatacentersFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'datacenters' => array_map(
                static fn () => GetDatacenterFixture::data()['datacenter'],
                range(1, fake()->numberBetween(1, 5))
            ),
            'meta' => PaginationFixture::data(),
            'recommendation' => fake()->numberBetween(1, 5),
        ];
    }
}
