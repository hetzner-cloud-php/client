<?php

declare(strict_types=1);

namespace Tests\Fixtures\Certificates;

use Tests\Fixtures\AbstractDataFixture;
use Tests\Fixtures\Actions\GetActionFixture;

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
