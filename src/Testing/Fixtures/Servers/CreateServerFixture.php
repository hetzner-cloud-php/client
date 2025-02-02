<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Servers;

use HetznerCloud\HttpClientUtilities\Testing\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;
use HetznerCloud\Testing\Fixtures\Concerns\HasErrorFixture;

use function Pest\Faker\fake;

final class CreateServerFixture extends AbstractDataFixture
{
    use HasErrorFixture;

    public static function data(): array
    {
        return [
            'action' => GetActionFixture::data()['action'],
            'next_actions' => array_map(
                static fn () => GetActionFixture::data()['action'],
                range(1, fake()->numberBetween(1, 3))
            ),
            'root_password' => fake()->password(20, 20),
            'server' => GetServerFixture::data()['server'],
        ];
    }
}
