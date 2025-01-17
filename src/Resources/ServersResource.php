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
 * @phpstan-import-type DeleteServerResponseSchema from DeleteServerResponse
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
    public function getServers(int $page = 1, int $perPage = 25, ?string $sort = null): GetServersResponse
    {
        $request = ClientRequestBuilder::get('servers')
            ->withQueryParams([
                'page' => $page,
                'per_page' => $perPage,
                'sort' => $sort,
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

    /**
     * @param array{
     *     name: string,
     *     image: string,
     *     server_type: string,
     *     automount?: bool,
     *     datacenter?: bool,
     *     firewalls?: array<int, array{firewall: int}>,
     *     labels?: array<string, string>,
     *     location?: string,
     *     networks?: int[],
     *     placement_group?: int,
     *     public_net?: array{enable_ipv4: bool, enable_ipv6: bool, ipv4?: int, ipv6?: int},
     *     ssh_keys?: string[],
     *     start_after_mount?: bool,
     *     user_data?: string,
     *     volumes?: int[],
     * } $payload
     */
    #[Override]
    public function createServer(array $payload): CreateServerResponse
    {
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

        /** @var DeleteServerResponseSchema $data */
        $data = $response->data();

        return DeleteServerResponse::from($data);
    }

    /**
     * @param  array{name?: string, labels?: array<string,string>}  $payload
     */
    public function updateServer(int $id, array $payload): GetServerResponse
    {
        $payload = ClientRequestBuilder::put("servers/$id")
            ->withRequestContent($payload);

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
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'step' => $step,
            ]);

        foreach ($types as $type) {
            $request = $request->withQueryParam('type', $type);
        }

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetServerMetricsResponseSchema $data */
        $data = $response->data();

        return GetServerMetricsResponse::from($data);
    }
}
