<?php

declare(strict_types=1);

namespace HetznerCloud\Testing\Responses;

use Carbon\Carbon;
use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\Responses\Firewalls\Models\ServerResource;
use HetznerCloud\Responses\Servers\CreateServerResponse;
use HetznerCloud\Responses\Servers\DeleteServerResponse;
use HetznerCloud\Responses\Servers\GetServerMetricsResponse;
use HetznerCloud\Responses\Servers\GetServerResponse;
use HetznerCloud\Responses\Servers\GetServersResponse;
use HetznerCloud\Testing\Resources\Concerns\Testable;

final class ServersTestResource implements ServersResourceContract
{
    use Testable;

    public function resource(): string
    {
        return ServerResource::class;
    }

    public function createServer(array $payload): CreateServerResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function getServers(int $page = 1, int $perPage = 25, ?string $sort = null): GetServersResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function getServer(int $id): GetServerResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function deleteServer(int $id): DeleteServerResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function updateServer(int $id, array $payload): GetServerResponse
    {
        return $this->record(__FUNCTION__, func_get_args());
    }

    public function getServerMetrics(
        int $id,
        array $types,
        Carbon $start,
        Carbon $end,
        ?int $step = null
    ): GetServerMetricsResponse {
        return $this->record(__FUNCTION__, func_get_args());
    }
}
