<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Certificates;

use HetznerCloud\Testing\Fixtures\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;

final class CreateCertificateFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'certificate' => GetCertificateFixture::data()['certificate'],
            'action' => GetActionFixture::data()['action'],
        ];
    }
}
