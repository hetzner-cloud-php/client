<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Servers;

use HetznerCloud\Testing\Fixtures\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\ErrorFixture;
use Override;

use function Pest\Faker\fake;

final class GetServerMetricsFixture extends AbstractDataFixture
{
    #[Override]
    public static function error(): array
    {
        return [
            'metrics' => null,
            'error' => ErrorFixture::data(),
        ];
    }

    public static function data(): array
    {
        // Generate a base timestamp for consistent time series
        $baseTimestamp = strtotime('2023-01-01 00:00:00');

        // Generate time series values for a 24-hour period with 1-hour intervals
        $timeSeriesValues = array_map(
            fn (int $hour): array => [
                (float) ($baseTimestamp + ($hour * 3600)),
                (string) fake()->numberBetween(1, 100),
            ],
            range(0, 23)
        );

        return [
            'metrics' => [
                'end' => fake()->iso8601(),
                'start' => fake()->iso8601(),
                'step' => fake()->randomElement([60, 300, 600]), // Common step intervals in seconds
                'time_series' => [
                    'cpu' => [
                        'values' => $timeSeriesValues,
                    ],
                    'memory' => [
                        'values' => array_map(
                            static fn (array $entry): array => [
                                $entry[0],
                                (string) fake()->numberBetween(512, 4096),
                            ],
                            $timeSeriesValues
                        ),
                    ],
                    'disk_bandwidth' => [
                        'values' => array_map(
                            static fn (array $entry): array => [
                                $entry[0],
                                (string) fake()->numberBetween(1000, 50000),
                            ],
                            $timeSeriesValues
                        ),
                    ],
                    'network_bandwidth' => [
                        'values' => array_map(
                            static fn (array $entry): array => [
                                $entry[0],
                                (string) fake()->numberBetween(100, 1000),
                            ],
                            $timeSeriesValues
                        ),
                    ],
                ],
            ],
        ];
    }
}
