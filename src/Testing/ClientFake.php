<?php

declare(strict_types=1);

namespace HetznerCloud\Testing;

use HetznerCloud\Contracts\ClientContract;
use HetznerCloud\Contracts\Resources\ActionsResourceContract;
use HetznerCloud\Contracts\Resources\CertificatesResourceContract;
use HetznerCloud\Contracts\Resources\DatacentersResourceContract;
use HetznerCloud\Contracts\Resources\FirewallsResourceContract;
use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ResponseContract;
use HetznerCloud\HttpClientUtilities\Testing\ClientProxyFake;
use HetznerCloud\Testing\Resources\ActionsTestResource;
use HetznerCloud\Testing\Resources\ServersTestResource;
use RuntimeException;
use Throwable;

final class ClientFake implements ClientContract
{
    public ClientProxyFake $proxy;

    /**
     * @template TResponse of ResponseContract<array<array-key, mixed>>
     *
     * @param  array<int, TResponse|Throwable>  $responses
     */
    public function __construct(array $responses = [])
    {
        $this->proxy = new ClientProxyFake($responses);
    }

    public function servers(): ServersResourceContract
    {
        return new ServersTestResource($this->proxy);
    }

    public function actions(): ActionsResourceContract
    {
        return new ActionsTestResource($this->proxy);
    }

    public function certificates(): CertificatesResourceContract
    {
        throw new RuntimeException('Method certificates() not implemented.');
    }

    public function datacenters(): DatacentersResourceContract
    {
        throw new RuntimeException('Method datacenters() not implemented.');
    }

    public function firewalls(): FirewallsResourceContract
    {
        throw new RuntimeException('Method firewalls() not implemented.');
    }
}
