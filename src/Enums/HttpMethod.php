<?php

declare(strict_types=1);

namespace HetznerCloud\Enums;

/**
 * Represents various HTTP methods utilized for sending requests.
 */
enum HttpMethod: string
{
    case GET = 'GET';

    case POST = 'POST';
}
