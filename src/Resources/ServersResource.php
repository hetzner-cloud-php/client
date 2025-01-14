<?php

declare(strict_types=1);

namespace HetznerCloud\Resources;

use Carbon\Carbon;
use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Support\ClientRequestBuilder;
use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Responses\Servers\CreateServerResponse;
use HetznerCloud\Responses\Servers\DeleteServerResponse;
use HetznerCloud\Responses\Servers\GetServerMetricsResponse;
use HetznerCloud\Responses\Servers\GetServerResponse;
use HetznerCloud\Responses\Servers\GetServersResponse;
use Override;

/**
 * @phpstan-import-type CreateServerResponseSchema from CreateServerResponse
 * @phpstan-import-type Action from CreateServerResponse
 * @phpstan-import-type GetServerResponseSchema from GetServerResponse
 * @phpstan-import-type GetServersResponseSchema from GetServersResponse
 * @phpstan-import-type GetServerMetricsResponseSchema from GetServerMetricsResponse
 */
final readonly class ServersResource implements ServersResourceContract
{
    public function __construct(
        public ConnectorContract $connector
    ) {
        //
    }

    #[Override]
    public function getServers(int $page = 1, int $perPage = 25): GetServersResponse
    {
        $request = ClientRequestBuilder::get('servers')
            ->withQueryParams([
                'page' => $page,
                'per_page' => $perPage,
            ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetServersResponseSchema $data */
        $data = $response->data();

        return GetServersResponse::from($data);
    }

    #[Override]
    public function getServer(int $id): GetServerResponse
    {
        $request = ClientRequestBuilder::get("servers/$id");

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

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
        $payload = [
            'name' => $name,
            'image' => $image,
            'server_type' => $serverType,
            'automount' => $automount,
            'start_after_create' => $automount,
            'datacenter' => $datacenter,
            'firewalls' => $firewalls,
            'labels' => $labels,
            'location' => $location,
            'networks' => $networks,
            'placement_group' => $placementGroup,
            'public_net' => $publicNet,
            'ssh_keys' => $sshKeys,
            'user_data' => $userData,
            'volumes' => $volumes,
        ];

        $payload = array_filter($payload, fn (mixed $value): bool => $value !== null);
        $request = ClientRequestBuilder::post('servers')
            ->withRequestContent($payload);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var CreateServerResponseSchema $data */
        $data = $response->data();

        return CreateServerResponse::from($data);
    }

    public function deleteServer(int $id): DeleteServerResponse
    {
        $request = ClientRequestBuilder::delete("servers/$id");

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var array{action: Action} $data */
        $data = $response->data();

        return DeleteServerResponse::from($data);
    }

    public function updateServer(int $id, ?string $name, ?array $labels): GetServerResponse
    {
        $payload = ClientRequestBuilder::put("servers/$id")
            ->withRequestContent([
                'name' => $name,
                'labels' => $labels,
            ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($payload);

        /** @var GetServerResponseSchema $data */
        $data = $response->data();

        return GetServerResponse::from($data);
    }

    public function getServerMetrics(int $id, array $types, Carbon $start, Carbon $end, ?int $step = null): GetServerMetricsResponse
    {
        $request = ClientRequestBuilder::get("servers/$id", 'metrics')
            ->withQueryParams([
                'type' => $types,
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'step' => $step,
            ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetServerMetricsResponseSchema $data */
        $data = $response->data();

        return GetServerMetricsResponse::from($data);
    }
}
