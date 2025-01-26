<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Servers;

use HetznerCloud\Testing\Fixtures\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;
use HetznerCloud\Testing\Fixtures\ErrorFixture;
use Override;

use function Pest\Faker\fake;

final class CreateServerFixture extends AbstractDataFixture
{
    #[Override]
    public static function error(): array
    {
        return [
            'action' => null,
            'next_actions' => null,
            'root_password' => null,
            'server' => null,
            'error' => ErrorFixture::data(),
        ];
    }

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
