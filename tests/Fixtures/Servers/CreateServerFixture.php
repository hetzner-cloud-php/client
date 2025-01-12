<?php

declare(strict_types=1);

namespace Tests\Fixtures\Servers;

use Tests\Fixtures\AbstractDataFixture;

use function Pest\Faker\fake;

final class CreateServerFixture extends AbstractDataFixture
{
    /**
     * @return array<array-key, mixed>
     */
    public static function data(): array
    {
        $serverId = fake()->numberBetween(1, 1000);

        return [
            'action' => [
                'command' => 'create_server',
                'error' => fake()->boolean(20) ? [
                    'code' => fake()->randomElement(['action_failed', 'server_creation_failed', 'resource_unavailable']),
                    'message' => fake()->sentence(),
                ] : null,
                'finished' => fake()->boolean(70) ? fake()->iso8601() : null,
                'id' => fake()->numberBetween(1, 1000),
                'progress' => fake()->numberBetween(0, 100),
                'resources' => [
                    [
                        'id' => $serverId,
                        'type' => 'server',
                    ],
                ],
                'started' => fake()->iso8601(),
                'status' => fake()->randomElement(['running', 'success', 'error']),
            ],
            'next_actions' => array_map(
                fn (): array => [
                    'command' => fake()->randomElement([
                        'start_server',
                        'stop_server',
                        'create_image',
                        'attach_volume',
                    ]),
                    'error' => fake()->boolean(10) ? [
                        'code' => fake()->randomElement(['action_failed', 'resource_unavailable']),
                        'message' => fake()->sentence(),
                    ] : null,
                    'finished' => fake()->boolean(30) ? fake()->iso8601() : null,
                    'id' => fake()->numberBetween(1, 1000),
                    'progress' => fake()->numberBetween(0, 100),
                    'resources' => [
                        [
                            'id' => $serverId,
                            'type' => 'server',
                        ],
                    ],
                    'started' => fake()->iso8601(),
                    'status' => fake()->randomElement(['running', 'pending', 'success', 'error']),
                ],
                range(1, fake()->numberBetween(1, 3))
            ),
            'root_password' => fake()->password(20, 20),
            'server' => GetServerFixture::data()['server'],
        ];
    }
}
