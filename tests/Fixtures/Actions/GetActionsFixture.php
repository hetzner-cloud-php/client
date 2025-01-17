<?php

declare(strict_types=1);

namespace Tests\Fixtures\Actions;

use Tests\Fixtures\AbstractDataFixture;
use Tests\Fixtures\PaginationFixture;

use function Pest\Faker\fake;

final class GetActionsFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'meta' => PaginationFixture::data(),
            'actions' => array_map(
                fn (): array => GetActionFixture::data()['action'],
                range(1, fake()->numberBetween(1, 5))
            ),
        ];
    }
}
