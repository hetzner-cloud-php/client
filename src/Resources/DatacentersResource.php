<?php

declare(strict_types=1);

namespace HetznerCloud\Resources;

use HetznerCloud\Contracts\Resources\DatacentersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Support\ClientRequestBuilder;
use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Responses\Datacenters\GetDatacenterResponse;
use HetznerCloud\Responses\Datacenters\GetDatacentersResponse;

/**
 * @phpstan-import-type GetDatacenterResponseSchema from GetDatacenterResponse
 * @phpstan-import-type GetDatacentersResponseSchema from GetDatacentersResponse
 */
final readonly class DatacentersResource implements DatacentersResourceContract
{
    public function __construct(
        public ConnectorContract $connector
    ) {
        //
    }

    public function getDatacenters(
        ?string $name = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetDatacentersResponse {
        $request = ClientRequestBuilder::get('datacenters')
            ->withQueryParams([
                'page' => $page,
                'per_page' => $perPage,
                'sort' => $sort,
                'name' => $name,
            ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetDatacentersResponseSchema $data */
        $data = $response->data();

        return GetDatacentersResponse::from($data);
    }

    public function getDatacenter(int $id): GetDatacenterResponse
    {
        $request = ClientRequestBuilder::get("datacenters/$id");

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetDatacenterResponseSchema $data */
        $data = $response->data();

        return GetDatacenterResponse::from($data);
    }
}
