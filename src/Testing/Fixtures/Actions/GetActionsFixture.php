<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Actions;

use HetznerCloud\HttpClientUtilities\Testing\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\PaginationFixture;

use function Pest\Faker\fake;

final class GetActionsFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'meta' => PaginationFixture::data(),
            'actions' => array_map(
                static fn () => GetActionFixture::data()['action'],
                range(1, fake()->numberBetween(1, 5))
            ),
        ];
    }
}
