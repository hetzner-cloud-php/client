<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Resources;

use HetznerCloud\Responses\Firewalls\GetFirewallResponse;
use HetznerCloud\Responses\Firewalls\GetFirewallsResponse;

interface FirewallsResourceContract
{
    public function getFirewalls(
        ?string $name = null,
        ?string $sort = null,
        ?string $labelSelector = null,
        int $page = 1,
        int $perPage = 25
    ): GetFirewallsResponse;

    public function getFirewall(int $id): GetFirewallResponse;
}
