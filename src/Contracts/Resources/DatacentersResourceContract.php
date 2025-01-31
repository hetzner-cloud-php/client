<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Resources;

use HetznerCloud\Responses\Resources\Datacenters\GetDatacenterResponse;
use HetznerCloud\Responses\Resources\Datacenters\GetDatacentersResponse;

interface DatacentersResourceContract
{
    public function getDatacenters(
        ?string $name = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetDatacentersResponse;

    public function getDatacenter(int $id): GetDatacenterResponse;
}
