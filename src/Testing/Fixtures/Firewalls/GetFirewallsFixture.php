<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Firewalls;

use HetznerCloud\Testing\Fixtures\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\PaginationFixture;

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
