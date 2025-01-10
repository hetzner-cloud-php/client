<?php

declare(strict_types=1);

namespace HetznerCloud\Resources;

use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\Response;
use HetznerCloud\HttpClientUtilities\ValueObjects\Payload;
use HetznerCloud\Responses\Servers\GetServersResponse;

/**
 * @phpstan-import-type GetServersResponseSchema from GetServersResponse
 */
final readonly class ServersResource implements ServersResourceContract
{
    public function __construct(
        private ConnectorContract $connector,
        private string $apiKey,
    ) {
        //
    }

    public function getServers(int $page = 1, int $perPage = 25): GetServersResponse
    {
        $payload = Payload::list('servers', [
            'page' => $page,
            'per_page' => $perPage,
        ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->makeRequest($payload, $this->apiKey);

        /** @var GetServersResponseSchema $data */
        $data = $response->data();

        return GetServersResponse::from($data);
    }
}
