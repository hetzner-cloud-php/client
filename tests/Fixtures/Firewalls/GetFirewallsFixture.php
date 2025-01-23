<?php

declare(strict_types=1);

namespace Tests\Fixtures\Firewalls;

use Tests\Fixtures\AbstractDataFixture;
use Tests\Fixtures\PaginationFixture;

use function Pest\Faker\fake;

final class GetFirewallsFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'firewalls' => array_map(
                static fn () => GetFirewallFixture::data()['firewall'],
                range(1, fake()->numberBetween(1, 5))
            ),
            'meta' => PaginationFixture::data(),
        ];
    }
}
