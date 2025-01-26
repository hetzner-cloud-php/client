<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures;

use function Pest\Faker\fake;

final class PaginationFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'pagination' => [
                'last_page' => fake()->numberBetween(1, 10),
                'next_page' => fake()->numberBetween(2, 10),
                'page' => fake()->numberBetween(1, 5),
                'per_page' => 25,
                'previous_page' => fake()->numberBetween(1, 4),
                'total_entries' => fake()->numberBetween(50, 200),
            ],
        ];
    }
}
