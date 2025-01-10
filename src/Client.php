<?php

declare(strict_types=1);

namespace HetznerCloud;

use HetznerCloud\Contracts\ConnectorContract;

/**
 * The primary client gateway for connecting to Bluesky's API containing all connections to the available resources.
 */
final readonly class Client
{
    /**
     * The base URL for the Bluesky API, requires authentication by default.
     */
    public const string API_BASE_URL = 'https://bsky.social/xrpc';

    /**
     * Creates a client instance with the provided client transport abstraction.
     */
    public function __construct(public ConnectorContract $connector)
    {
        //
    }
}
