<?php

declare(strict_types=1);

namespace Tests\Fixtures\Servers;

use Tests\Fixtures\AbstractDataFixture;

use function Pest\Faker\fake;

final class GetServersFixture extends AbstractDataFixture
{
    /**
     * @return array<array-key, mixed>
     */
    public static function data(): array
    {
        return [
            'meta' => [
                'pagination' => [
                    'last_page' => fake()->numberBetween(1, 10),
                    'next_page' => fake()->numberBetween(2, 10),
                    'page' => fake()->numberBetween(1, 5),
                    'per_page' => 25,
                    'previous_page' => fake()->numberBetween(1, 4),
                    'total_entries' => fake()->numberBetween(50, 200),
                ],
            ],
            'servers' => array_map(
                fn (): array => GetServerFixture::data(),
                range(1, fake()->numberBetween(1, 5))
            ),
        ];
    }
}
