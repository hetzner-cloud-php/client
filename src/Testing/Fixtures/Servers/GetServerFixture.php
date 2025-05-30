<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Servers;

use HetznerCloud\HttpClientUtilities\Testing\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\Concerns\HasErrorFixture;

final class GetServerFixture extends AbstractDataFixture
{
    use HasErrorFixture;

    public static function data(): array
    {
        return [
            'server' => [
                'backup_window' => '22-02',
                'created' => '2016-01-30T23:55:00+00:00',
                'datacenter' => [
                    'description' => 'Falkenstein DC Park 8',
                    'id' => 42,
                    'location' => [
                        'city' => 'Falkenstein',
                        'country' => 'DE',
                        'description' => 'Falkenstein DC Park 1',
                        'id' => 42,
                        'latitude' => 50.47612,
                        'longitude' => 12.370071,
                        'name' => 'fsn1',
                        'network_zone' => 'eu-central',
                    ],
                    'name' => 'fsn1-dc8',
                    'server_types' => [
                        'available' => [
                            1,
                            2,
                            3,
                        ],
                        'available_for_migration' => [
                            1,
                            2,
                            3,
                        ],
                        'supported' => [
                            1,
                            2,
                            3,
                        ],
                    ],
                ],
                'id' => 42,
                'image' => [
                    'architecture' => 'x86',
                    'bound_to' => null,
                    'created' => '2016-01-30T23:55:00+00:00',
                    'created_from' => [
                        'id' => 1,
                        'name' => 'Server',
                    ],
                    'deleted' => null,
                    'deprecated' => '2018-02-28T00:00:00+00:00',
                    'description' => 'Ubuntu 20.04 Standard 64 bit',
                    'disk_size' => 10,
                    'id' => 42,
                    'image_size' => 2.3,
                    'labels' => [
                        'environment' => 'prod',
                        'example.com/my' => 'label',
                        'just-a-key' => '',
                    ],
                    'name' => 'ubuntu-20.04',
                    'os_flavor' => 'ubuntu',
                    'os_version' => '20.04',
                    'protection' => [
                        'delete' => false,
                    ],
                    'rapid_deploy' => false,
                    'status' => 'available',
                    'type' => 'snapshot',
                ],
                'included_traffic' => 654321,
                'ingoing_traffic' => 123456,
                'iso' => [
                    'architecture' => 'x86',
                    'deprecation' => [
                        'announced' => '2023-06-01T00:00:00+00:00',
                        'unavailable_after' => '2023-09-01T00:00:00+00:00',
                    ],
                    'description' => 'FreeBSD 11.0 x64',
                    'id' => 42,
                    'name' => 'FreeBSD-11.0-RELEASE-amd64-dvd1',
                    'type' => 'public',
                ],
                'labels' => [
                    'environment' => 'prod',
                    'example.com/my' => 'label',
                    'just-a-key' => '',
                ],
                'load_balancers' => [
                    0,
                ],
                'locked' => false,
                'name' => 'my-resource',
                'outgoing_traffic' => 123456,
                'placement_group' => [
                    'created' => '2016-01-30T23:55:00+00:00',
                    'id' => 42,
                    'labels' => [
                        'environment' => 'prod',
                        'example.com/my' => 'label',
                        'just-a-key' => '',
                    ],
                    'name' => 'my-resource',
                    'servers' => [
                        42,
                    ],
                    'type' => 'spread',
                ],
                'primary_disk_size' => 50,
                'private_net' => [
                    [
                        'alias_ips' => [
                            '10.0.0.3',
                            '10.0.0.4',
                        ],
                        'ip' => '10.0.0.2',
                        'mac_address' => '86:00:ff:2a:7d:e1',
                        'network' => 4711,
                    ],
                ],
                'protection' => [
                    'delete' => false,
                    'rebuild' => false,
                ],
                'public_net' => [
                    'firewalls' => [
                        [
                            'id' => 42,
                            'status' => 'applied',
                        ],
                    ],
                    'floating_ips' => [
                        478,
                    ],
                    'ipv4' => [
                        'blocked' => false,
                        'dns_ptr' => 'server01.example.com',
                        'id' => 42,
                        'ip' => '1.2.3.4',
                    ],
                    'ipv6' => [
                        'blocked' => false,
                        'dns_ptr' => [
                            [
                                'dns_ptr' => 'server.example.com',
                                'ip' => '2001:db8::1',
                            ],
                        ],
                        'id' => 42,
                        'ip' => '2001:db8::/64',
                    ],
                ],
                'rescue_enabled' => false,
                'server_type' => [
                    'architecture' => 'x86',
                    'cores' => 2,
                    'cpu_type' => 'shared',
                    'deprecated' => false,
                    'deprecation' => [
                        'announced' => '2023-06-01T00:00:00+00:00',
                        'unavailable_after' => '2023-09-01T00:00:00+00:00',
                    ],
                    'description' => 'CPX11',
                    'disk' => 40,
                    'id' => 1,
                    'memory' => 2,
                    'name' => 'cpx11',
                    'prices' => [
                        [
                            'included_traffic' => 654321,
                            'location' => 'fsn1',
                            'price_hourly' => [
                                'gross' => '1.1900',
                                'net' => '1.0000',
                            ],
                            'price_monthly' => [
                                'gross' => '1.1900',
                                'net' => '1.0000',
                            ],
                            'price_per_tb_traffic' => [
                                'gross' => '1.1900',
                                'net' => '1.0000',
                            ],
                        ],
                    ],
                    'storage_type' => 'local',
                ],
                'status' => 'running',
                'volumes' => [
                    0,
                ],
            ],
        ];
    }
}
