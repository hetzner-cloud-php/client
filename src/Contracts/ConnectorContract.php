<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts;

use HetznerCloud\ValueObjects\Connector\BaseUri;
use HetznerCloud\ValueObjects\Connector\Headers;
use HetznerCloud\ValueObjects\Connector\Response;
use HetznerCloud\ValueObjects\Payload;

/**
 * A top-level client connector that represents communication methods with the API.
 *
 * @internal
 */
interface ConnectorContract
{
    /**
     * Sends a request to the server, determining if authentication is required.
     *
     * @return null|Response<array<array-key, mixed>>
     */
    public function makeRequest(Payload $payload, ?string $accessToken): ?Response;

    /**
     * Sends a request to the server.
     *
     * @return null|Response<array<array-key, mixed>>
     */
    public function requestData(Payload $payload): ?Response;

    /**
     * Sends a request to the server with an access token.
     *
     * @return null|Response<array<array-key, mixed>>
     */
    public function requestDataWithAccessToken(Payload $payload, string $accessToken): ?Response;

    public function getHeaders(): Headers;

    public function getBaseUri(): BaseUri;
}
