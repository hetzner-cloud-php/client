<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Resources;

use HetznerCloud\Responses\Servers\GetServerResponse;
use HetznerCloud\Responses\Servers\GetServersResponse;

interface ServersResourceContract
{
    public function getServers(int $page = 1, int $perPage = 25): GetServersResponse;

    public function getServer(int $id): GetServerResponse;
}
