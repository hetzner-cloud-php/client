<?php

declare(strict_types=1);

namespace HetznerCloud\Resources;

use HetznerCloud\Contracts\Resources\FirewallsResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Support\ClientRequestBuilder;
use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Responses\Firewalls\GetFirewallResponse;
use HetznerCloud\Responses\Firewalls\GetFirewallsResponse;

/**
 * @phpstan-import-type GetFirewallResponseSchema from GetFirewallResponse
 * @phpstan-import-type GetFirewallsResponseSchema from GetFirewallsResponse
 */
final readonly class FirewallsResource implements FirewallsResourceContract
{
    public function __construct(
        public ConnectorContract $connector
    ) {}

    public function getFirewalls(
        ?string $name = null,
        ?string $sort = null,
        ?string $labelSelector = null,
        int $page = 1,
        int $perPage = 25
    ): GetFirewallsResponse {
        $request = ClientRequestBuilder::get('firewalls')
            ->withQueryParams([
                'page' => $page,
                'per_page' => $perPage,
                'sort' => $sort,
                'label_selector' => $labelSelector,
                'name' => $name,
            ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetFirewallsResponseSchema $data */
        $data = $response->data();

        return GetFirewallsResponse::from($data);
    }

    public function getFirewall(int $id): GetFirewallResponse
    {
        $request = ClientRequestBuilder::get("firewalls/$id");

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetFirewallResponseSchema $data */
        $data = $response->data();

        return GetFirewallResponse::from($data);
    }
}
