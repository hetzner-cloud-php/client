<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures\Actions;

use HetznerCloud\HttpClientUtilities\Testing\AbstractDataFixture;
use HetznerCloud\Testing\Fixtures\Concerns\HasErrorFixture;

final class GetActionFixture extends AbstractDataFixture
{
    use HasErrorFixture;

    public static function data(): array
    {
        return [
            'action' => [
                'command' => 'start_resource',
                'error' => [
                    'code' => 'action_failed',
                    'message' => 'Action failed',
                ],
                'finished' => '2016-01-30T23:55:00+00:00',
                'id' => 42,
                'progress' => 100,
                'resources' => [
                    [
                        'id' => 42,
                        'type' => 'server',
                    ],
                ],
                'started' => '2016-01-30T23:55:00+00:00',
                'status' => 'running',
            ],
        ];
    }
}
