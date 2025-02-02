<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Certificates;

use HetznerCloud\HttpClientUtilities\Testing\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;
use HetznerCloud\Testing\Fixtures\Concerns\HasErrorFixture;

final class CreateCertificateFixture extends AbstractDataFixture
{
    use HasErrorFixture;

    public static function data(): array
    {
        return [
            'certificate' => GetCertificateFixture::data()['certificate'],
            'action' => GetActionFixture::data()['action'],
        ];
    }
}
