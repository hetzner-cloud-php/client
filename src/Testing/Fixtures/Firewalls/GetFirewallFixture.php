<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Firewalls;

use HetznerCloud\HttpClientUtilities\Testing\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\Concerns\HasErrorFixture;

final class GetFirewallFixture extends AbstractDataFixture
{
    use HasErrorFixture;

    public static function data(): array
    {
        return [
            'firewall' => [
                'applied_to' => [
                    [
                        'applied_to_resources' => [
                            [
                                'server' => [
                                    'id' => 42,
                                ],
                                'type' => 'server',
                            ],
                        ],
                        'label_selector' => [
                            'selector' => 'env=prod',
                        ],
                        'server' => [
                            'id' => 42,
                        ],
                        'type' => 'server',
                    ],
                ],
                'created' => '2016-01-30T23:55:00+00:00',
                'id' => 42,
                'labels' => [
                    'environment' => 'prod',
                    'example.com/my' => 'label',
                    'just-a-key' => '',
                ],
                'name' => 'new-name',
                'rules' => [
                    [
                        'description' => 'Coolify',
                        'destination_ips' => [
                        ],
                        'direction' => 'in',
                        'port' => '80',
                        'protocol' => 'tcp',
                        'source_ips' => [
                            '28.239.13.1/32',
                            '28.239.14.0/24',
                            'ff21:1eac:9a3b:ee58:5ca:990c:8bc9:c03b/128',
                        ],
                    ],
                ],
            ],
        ];
    }
}
