<?php

declare(strict_types=1);

namespace Tests\Fixtures\Servers;

use Tests\Fixtures\AbstractDataFixture;
use Tests\Fixtures\Actions\GetActionFixture;

use function Pest\Faker\fake;

final class CreateServerFixture extends AbstractDataFixture
{
    /**
     * @return array<array-key, mixed>
     */
    public static function data(): array
    {
        return [
            'action' => GetActionFixture::data()['action'],
            'next_actions' => array_map(
                fn () => GetActionFixture::data()['action'],
                range(1, fake()->numberBetween(1, 3))
            ),
            'root_password' => fake()->password(20, 20),
            'server' => GetServerFixture::data()['server'],
        ];
    }
}
