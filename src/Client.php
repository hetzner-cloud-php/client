<?php

declare(strict_types=1);

namespace HetznerCloud;

use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\Resources\ServersResource;

/**
 * The primary client gateway for connecting to Bluesky's API containing all connections to the available resources.
 */
final readonly class Client
{
    /**
     * The base URL for the Bluesky API, requires authentication by default.
     */
    public const string API_BASE_URL = 'https://api.hetzner.cloud/v1';

    /**
     * Creates a client instance with the provided client transport abstraction.
     */
    public function __construct(
        public ConnectorContract $connector,
        public string $apiKey,
    ) {
        //
    }

    public function servers(): ServersResourceContract
    {
        return new ServersResource($this->connector, $this->apiKey);
    }
}
