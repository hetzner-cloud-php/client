<?php

declare(strict_types=1);

namespace Tests\Fixtures\Certificates;

use Tests\Fixtures\AbstractDataFixture;
use Tests\Fixtures\PaginationFixture;

final class GetCertificatesFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'meta' => PaginationFixture::data(),
            'certificates' => array_map(
                static fn () => GetCertificateFixture::data()['certificate'],
                range(1, 5)
            ),
        ];
    }
}
