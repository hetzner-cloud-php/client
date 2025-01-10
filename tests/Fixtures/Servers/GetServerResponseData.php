<?php

declare(strict_types=1);

namespace Tests\Fixtures\Servers;

use function Pest\Faker\fake;

/**
 * @return array<array-key, mixed>
 */
function server(): array
{
    return [
        'server' => [
            'backup_window' => sprintf('%02d-%02d', fake()->numberBetween(0, 23), fake()->numberBetween(0, 23)),
            'created' => fake()->iso8601(),
            'datacenter' => [
                'description' => fake()->word().' DC Park '.fake()->numberBetween(1, 10),
                'id' => fake()->numberBetween(1, 100),
                'location' => [
                    'city' => fake()->city(),
                    'country' => fake()->countryCode(),
                    'description' => fake()->sentence(),
                    'id' => fake()->numberBetween(1, 100),
                    'latitude' => fake()->latitude(),
                    'longitude' => fake()->longitude(),
                    'name' => strtolower(fake()->lexify('???')).fake()->numberBetween(1, 5),
                    'network_zone' => fake()->randomElement(['eu-central', 'us-east', 'us-west', 'ap-south']),
                ],
                'name' => sprintf(
                    '%s-dc%d',
                    strtolower(fake()->lexify('???')),
                    fake()->numberBetween(1, 10)
                ),
                'server_types' => [
                    'available' => array_map(
                        fn (): int => fake()->numberBetween(1, 10),
                        range(1, 3)
                    ),
                    'available_for_migration' => array_map(
                        fn (): int => fake()->numberBetween(1, 10),
                        range(1, 3)
                    ),
                    'supported' => array_map(
                        fn (): int => fake()->numberBetween(1, 10),
                        range(1, 3)
                    ),
                ],
            ],
            'id' => fake()->numberBetween(1, 1000),
            'image' => [
                'architecture' => fake()->randomElement(['x86', 'arm']),
                'bound_to' => null,
                'created' => fake()->iso8601(),
                'created_from' => [
                    'id' => fake()->numberBetween(1, 100),
                    'name' => 'Server',
                ],
                'deleted' => null,
                'deprecated' => fake()->iso8601(),
                'description' => sprintf(
                    '%s %s Standard %s bit',
                    fake()->randomElement(['Ubuntu', 'Debian', 'CentOS']),
                    fake()->semver(),
                    fake()->randomElement(['32', '64'])
                ),
                'disk_size' => fake()->numberBetween(10, 100),
                'id' => fake()->numberBetween(1, 1000),
                'image_size' => fake()->randomFloat(1, 1, 10),
                'labels' => [
                    'environment' => fake()->randomElement(['prod', 'staging', 'dev']),
                    sprintf('%s/my', fake()->domainName()) => fake()->word(),
                    'just-a-key' => '',
                ],
                'name' => sprintf(
                    '%s-%s',
                    strtolower((string) fake()->randomElement(['ubuntu', 'debian', 'centos'])),
                    fake()->semver()
                ),
                'os_flavor' => fake()->randomElement(['ubuntu', 'debian', 'centos']),
                'os_version' => fake()->semver(),
                'protection' => [
                    'delete' => fake()->boolean(),
                ],
                'rapid_deploy' => fake()->boolean(),
                'status' => fake()->randomElement(['available', 'creating', 'deprecated']),
                'type' => 'snapshot',
            ],
            'included_traffic' => fake()->numberBetween(100000, 1000000),
            'ingoing_traffic' => fake()->numberBetween(10000, 500000),
            'iso' => [
                'architecture' => fake()->randomElement(['x86', 'arm']),
                'deprecation' => [
                    'announced' => fake()->iso8601(),
                    'unavailable_after' => fake()->iso8601(),
                ],
                'description' => sprintf(
                    '%s %s x64',
                    fake()->randomElement(['FreeBSD', 'Ubuntu', 'Debian']),
                    fake()->semver()
                ),
                'id' => fake()->numberBetween(1, 100),
                'name' => sprintf(
                    '%s-%s-RELEASE-amd64-dvd1',
                    fake()->randomElement(['FreeBSD', 'Ubuntu', 'Debian']),
                    fake()->semver()
                ),
                'type' => 'public',
            ],
            'labels' => [
                'environment' => fake()->randomElement(['prod', 'staging', 'dev']),
                sprintf('%s/my', fake()->domainName()) => fake()->word(),
                'just-a-key' => '',
            ],
            'load_balancers' => [fake()->numberBetween(0, 10)],
            'locked' => fake()->boolean(),
            'name' => sprintf('server-%s', fake()->slug()),
            'outgoing_traffic' => fake()->numberBetween(10000, 500000),
            'placement_group' => [
                'created' => fake()->iso8601(),
                'id' => fake()->numberBetween(1, 100),
                'labels' => [
                    'environment' => fake()->randomElement(['prod', 'staging', 'dev']),
                    sprintf('%s/my', fake()->domainName()) => fake()->word(),
                    'just-a-key' => '',
                ],
                'name' => sprintf('group-%s', fake()->slug()),
                'servers' => [fake()->numberBetween(1, 100)],
                'type' => 'spread',
            ],
            'primary_disk_size' => fake()->numberBetween(20, 500),
            'private_net' => [
                [
                    'alias_ips' => [
                        sprintf('10.0.0.%d', fake()->numberBetween(2, 254)),
                        sprintf('10.0.0.%d', fake()->numberBetween(2, 254)),
                    ],
                    'ip' => sprintf('10.0.0.%d', fake()->numberBetween(2, 254)),
                    'mac_address' => fake()->macAddress(),
                    'network' => fake()->numberBetween(1000, 9999),
                ],
            ],
            'protection' => [
                'delete' => fake()->boolean(),
                'rebuild' => fake()->boolean(),
            ],
            'public_net' => [
                'firewalls' => [
                    [
                        'id' => fake()->numberBetween(1, 100),
                        'status' => fake()->randomElement(['applied', 'pending']),
                    ],
                ],
                'floating_ips' => [fake()->numberBetween(1, 1000)],
                'ipv4' => [
                    'blocked' => fake()->boolean(),
                    'dns_ptr' => sprintf('server%d.%s', fake()->numberBetween(1, 100), fake()->domainName()),
                    'id' => fake()->numberBetween(1, 100),
                    'ip' => fake()->ipv4(),
                ],
                'ipv6' => [
                    'blocked' => fake()->boolean(),
                    'dns_ptr' => [
                        [
                            'dns_ptr' => sprintf('server.%s', fake()->domainName()),
                            'ip' => fake()->ipv6(),
                        ],
                    ],
                    'id' => fake()->numberBetween(1, 100),
                    'ip' => sprintf('%s/64', fake()->ipv6()),
                ],
            ],
            'rescue_enabled' => fake()->boolean(),
            'server_type' => [
                'architecture' => fake()->randomElement(['x86', 'arm']),
                'cores' => fake()->numberBetween(1, 32),
                'cpu_type' => fake()->randomElement(['shared', 'dedicated']),
                'deprecated' => fake()->boolean(),
                'deprecation' => [
                    'announced' => fake()->iso8601(),
                    'unavailable_after' => fake()->iso8601(),
                ],
                'description' => sprintf('CPX%d', fake()->numberBetween(11, 51)),
                'disk' => fake()->numberBetween(20, 500),
                'id' => fake()->numberBetween(1, 100),
                'memory' => fake()->numberBetween(2, 256),
                'name' => sprintf('cpx%d', fake()->numberBetween(11, 51)),
                'prices' => [
                    [
                        'included_traffic' => fake()->numberBetween(100000, 1000000),
                        'location' => strtolower(fake()->lexify('???')).fake()->numberBetween(1, 5),
                        'price_hourly' => [
                            'gross' => sprintf('%.4f', fake()->randomFloat(4, 0, 10)),
                            'net' => sprintf('%.4f', fake()->randomFloat(4, 0, 10)),
                        ],
                        'price_monthly' => [
                            'gross' => sprintf('%.4f', fake()->randomFloat(4, 0, 500)),
                            'net' => sprintf('%.4f', fake()->randomFloat(4, 0, 500)),
                        ],
                        'price_per_tb_traffic' => [
                            'gross' => sprintf('%.4f', fake()->randomFloat(4, 0, 10)),
                            'net' => sprintf('%.4f', fake()->randomFloat(4, 0, 10)),
                        ],
                    ],
                ],
                'storage_type' => fake()->randomElement(['local', 'network']),
            ],
            'status' => fake()->randomElement(['running', 'stopped', 'starting', 'stopping']),
            'volumes' => [fake()->numberBetween(0, 10)],
        ],
    ];
}
