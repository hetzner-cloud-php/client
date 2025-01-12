<?php

declare(strict_types=1);

namespace HetznerCloud\Resources;

use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Enums\MediaType;
use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\Response;
use HetznerCloud\HttpClientUtilities\ValueObjects\Payload;
use HetznerCloud\Responses\Servers\CreateServerResponse;
use HetznerCloud\Responses\Servers\GetServerResponse;
use HetznerCloud\Responses\Servers\GetServersResponse;
use Override;

/**
 * @phpstan-import-type CreateServerResponseSchema from CreateServerResponse
 * @phpstan-import-type GetServerResponseSchema from GetServerResponse
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

    #[Override]
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

    #[Override]
    public function getServer(int $id): GetServerResponse
    {
        $payload = Payload::retrieve('servers', $id);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->makeRequest($payload, $this->apiKey);

        /** @var GetServerResponseSchema $data */
        $data = $response->data();

        return GetServerResponse::from($data);
    }

    #[Override]
    public function createServer(
        string $name,
        string $image,
        string $serverType,
        ?bool $automount = null,
        ?bool $startAfterCreate = null,
        ?array $volumes = null,
        ?string $datacenter = null,
        ?array $firewalls = null,
        ?array $labels = null,
        ?string $location = null,
        ?array $networks = null,
        ?int $placementGroup = null,
        ?array $publicNet = null,
        ?array $sshKeys = null,
        ?string $userData = null,
    ): CreateServerResponse {
        $payload = Payload::post('servers', [
            'name' => $name,
            'image' => $image,
            'server_type' => $serverType,
        ], contentType: MediaType::JSON)
            ->withOptionalParameter('automount', $automount)
            ->withOptionalParameter('start_after_create', $automount)
            ->withOptionalParameter('datacenter', $datacenter)
            ->withOptionalParameter('firewalls', $firewalls)
            ->withOptionalParameter('labels', $labels)
            ->withOptionalParameter('location', $location)
            ->withOptionalParameter('networks', $networks)
            ->withOptionalParameter('placement_group', $placementGroup)
            ->withOptionalParameter('public_net', $publicNet)
            ->withOptionalParameter('ssh_keys', $sshKeys)
            ->withOptionalParameter('user_data', $userData)
            ->withOptionalParameter('volumes', $volumes);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->makeRequest($payload, $this->apiKey);

        /** @var CreateServerResponseSchema $data */
        $data = $response->data();

        return CreateServerResponse::from($data);
    }
}
