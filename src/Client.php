<?php

declare(strict_types=1);

namespace HetznerCloud;

use HetznerCloud\Contracts\Resources\ActionsResourceContract;
use HetznerCloud\Contracts\Resources\CertificatesResourceContract;
use HetznerCloud\Contracts\Resources\DatacentersResourceContract;
use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\Resources\ActionsResource;
use HetznerCloud\Resources\CertificatesResource;
use HetznerCloud\Resources\DatacentersResource;
use HetznerCloud\Resources\ServersResource;

/**
 * The primary client gateway for connecting to Hetzner Cloud's API containing all connections to the available resources.
 */
final readonly class Client
{
    /**
     * The base URL for the Hetzner Cloud API, requires authentication by default.
     */
    public const string API_BASE_URL = 'https://api.hetzner.cloud/v1';

    /**
     * Creates a client instance with the provided client transport abstraction.
     */
    public function __construct(
        public ConnectorContract $connector
    ) {
        //
    }

    public function servers(): ServersResourceContract
    {
        return new ServersResource($this->connector);
    }

    public function actions(): ActionsResourceContract
    {
        return new ActionsResource($this->connector);
    }

    public function certificates(): CertificatesResourceContract
    {
        return new CertificatesResource($this->connector);
    }

    public function datacenters(): DatacentersResourceContract
    {
        return new DatacentersResource($this->connector);
    }
}
