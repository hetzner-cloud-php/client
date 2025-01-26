<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts;

use HetznerCloud\Contracts\Resources\ActionsResourceContract;
use HetznerCloud\Contracts\Resources\CertificatesResourceContract;
use HetznerCloud\Contracts\Resources\DatacentersResourceContract;
use HetznerCloud\Contracts\Resources\FirewallsResourceContract;
use HetznerCloud\Contracts\Resources\ServersResourceContract;

interface ClientContract
{
    public function servers(): ServersResourceContract;

    public function actions(): ActionsResourceContract;

    public function certificates(): CertificatesResourceContract;

    public function datacenters(): DatacentersResourceContract;

    public function firewalls(): FirewallsResourceContract;
}
