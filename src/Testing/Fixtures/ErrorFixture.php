<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Fixtures;

use HetznerCloud\HttpClientUtilities\Testing\AbstractDataFixture;

final class ErrorFixture extends AbstractDataFixture
{
    public static function data(): array
    {
        return [
            'message' => "invalid input in fields 'server_type', 'source_server', 'image'",
            'code' => 'invalid_input',
            'details' => [
                'fields' => [
                    [
                        'name' => 'server_type',
                        'messages' => [
                            'Missing data for required field.',
                        ],
                    ],
                    [
                        'name' => 'source_server',
                        'messages' => [
                            'source_server and image are mutually exclusive.',
                        ],
                    ],
                    [
                        'name' => 'image',
                        'messages' => [
                            'source_server and image are mutually exclusive.',
                        ],
                    ],
                ],
            ],
        ];
    }
}
