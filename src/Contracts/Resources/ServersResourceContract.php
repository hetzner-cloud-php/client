<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Resources;

use HetznerCloud\Responses\Servers\CreateServerResponse;
use HetznerCloud\Responses\Servers\GetServerResponse;
use HetznerCloud\Responses\Servers\GetServersResponse;

interface ServersResourceContract
{
    /**
     * @param  array<int, array{firewall: int}>|null  $firewalls
     * @param  array{string, string}|null  $labels
     * @param  int[]|null  $networks
     * @param  array{enable_ipv4: bool, enable_ipv6: bool, ipv4: ?string, ipv6: ?string}|null  $publicNet
     * @param  string[]|null  $sshKeys
     * @param  int[]|null  $volumes
     */
    public function createServer(
        string $name,
        string $image,
        string $serverType,
        ?bool $automount = true,
        ?bool $startAfterCreate = true,
        ?array $volumes = [],
        ?string $datacenter = null,
        ?array $firewalls = null,
        ?array $labels = null,
        ?string $location = null,
        ?array $networks = null,
        ?int $placementGroup = null,
        ?array $publicNet = null,
        ?array $sshKeys = null,
        ?string $userData = null,
    ): CreateServerResponse;

    public function getServers(int $page = 1, int $perPage = 25): GetServersResponse;

    public function getServer(int $id): GetServerResponse;
}
