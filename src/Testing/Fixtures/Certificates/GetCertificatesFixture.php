<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Certificates;

use HetznerCloud\HttpClientUtilities\Testing\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\PaginationFixture;

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
