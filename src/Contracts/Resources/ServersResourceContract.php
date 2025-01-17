<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Resources;

use Carbon\Carbon;
use HetznerCloud\Responses\Errors\ErrorResponse;
use HetznerCloud\Responses\Servers\CreateServerResponse;
use HetznerCloud\Responses\Servers\DeleteServerResponse;
use HetznerCloud\Responses\Servers\GetServerMetricsResponse;
use HetznerCloud\Responses\Servers\GetServerResponse;
use HetznerCloud\Responses\Servers\GetServersResponse;

interface ServersResourceContract
{
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
    public function createServer(array $payload): CreateServerResponse|ErrorResponse;

    public function getServers(int $page = 1, int $perPage = 25, ?string $sort = null): GetServersResponse;

    public function getServer(int $id): GetServerResponse;

    public function deleteServer(int $id): DeleteServerResponse;

    /**
     * @param  array{name?: string, labels?: array<string,string>}  $payload
     */
    public function updateServer(int $id, array $payload): GetServerResponse;

    /**
     * @param  string[]  $types
     */
    public function getServerMetrics(int $id, array $types, Carbon $start, Carbon $end, ?int $step = null): GetServerMetricsResponse;
}
