<?php

declare(strict_types=1);

namespace Tests\Fixtures\Certificates;

use Tests\Fixtures\AbstractDataFixture;

final class GetCertificateFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'certificate' => [
                'certificate' => '-----BEGIN CERTIFICATE-----\nasdf',
                'created' => '2019-01-08T12:10:00+00:00',
                'domain_names' => [
                    'example.com',
                    'webmail.example.com',
                    'www.example.com',
                ],
                'fingerprint' => '03:c7:55:9b:2a:d1:04:17:09:f6:d0:7f:18:34:63:d4:3e:5f',
                'id' => 897,
                'labels' => [
                    'env' => 'dev',
                ],
                'name' => 'my website cert',
                'not_valid_after' => '2019-07-08T09:59:59+00:00',
                'not_valid_before' => '2019-01-08T10:00:00+00:00',
                'status' => [
                    'error' => null,
                    'issuance' => 'pending',
                    'renewal' => 'pending',
                ],
                'type' => 'uploaded',
                'used_by' => [
                    [
                        'id' => 4711,
                        'type' => 'load_balancer',
                    ],
                ],
            ],
        ];
    }
}
