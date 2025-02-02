<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Resources;

use Carbon\Carbon;
use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Testing\Concerns\Testable;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Resources\Servers\CreateServerResponse;
use HetznerCloud\Responses\Resources\Servers\DeleteServerResponse;
use HetznerCloud\Responses\Resources\Servers\GetServerMetricsResponse;
use HetznerCloud\Responses\Resources\Servers\GetServerResponse;
use HetznerCloud\Responses\Resources\Servers\GetServersResponse;

/**
 * @phpstan-import-type CreateServerResponseSchema from CreateServerResponse
 * @phpstan-import-type DeleteServerResponseSchema from DeleteServerResponse
 * @phpstan-import-type GetServerResponseSchema from GetServerResponse
 * @phpstan-import-type GetServersResponseSchema from GetServersResponse
 * @phpstan-import-type GetServerMetricsResponseSchema from GetServerMetricsResponse
 *
 * @phpstan-type ServersResponseSchemas CreateServerResponseSchema|DeleteServerResponseSchema|GetServerResponseSchema|GetServersResponseSchema|GetServerMetricsResponseSchema
 */
final readonly class ServersTestResource implements ServersResourceContract
{
    /**
     * @use Testable<ServersResponseSchemas>
     */
    use Testable;

    /**
     * @return class-string
     */
    public function resource(): string
    {
        return ServersResource::class;
    }

    public function createServer(array $payload): CreateServerResponse
    {
        return $this->record(__FUNCTION__, func_get_args(), CreateServerResponse::class);
    }

    public function getServers(int $page = 1, int $perPage = 25, ?string $sort = null): GetServersResponse
    {
        return $this->record(__FUNCTION__, func_get_args(), GetServersResponse::class);
    }

    public function getServer(int $id): GetServerResponse
    {
        return $this->record(__FUNCTION__, func_get_args(), GetServerResponse::class);
    }

    public function deleteServer(int $id): DeleteServerResponse
    {
        return $this->record(__FUNCTION__, func_get_args(), DeleteServerResponse::class);
    }

    public function updateServer(int $id, array $payload): GetServerResponse
    {
        return $this->record(__FUNCTION__, func_get_args(), GetServerResponse::class);
    }

    public function getServerMetrics(
        int $id,
        array $types,
        Carbon $start,
        Carbon $end,
        ?int $step = null
    ): GetServerMetricsResponse {
        return $this->record(__FUNCTION__, func_get_args(), GetServerMetricsResponse::class);
    }
}
