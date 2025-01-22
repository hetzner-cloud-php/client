<?php

declare(strict_types=1);

namespace Tests\Fixtures\Datacenters;

use Tests\Fixtures\AbstractDataFixture;

final class GetDatacenterFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
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
        ];
    }
}
