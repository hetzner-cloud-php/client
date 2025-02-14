<?php

declare(strict_types=1);

namespace HetznerCloud\Resources;

use HetznerCloud\Contracts\Resources\CertificateActionsResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Support\ClientRequestBuilder;
use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\Concerns\SelfIdentifiedResource;
use HetznerCloud\Responses\Resources\Actions\GetActionResponse;
use HetznerCloud\Responses\Resources\Actions\GetActionsResponse;

/**
 * @phpstan-import-type GetActionResponseSchema from GetActionResponse
 * @phpstan-import-type GetActionsResponseSchema from GetActionsResponse
 */
final readonly class CertificateActionsResource implements CertificateActionsResourceContract
{
    use SelfIdentifiedResource;

    public function __construct(
        public ConnectorContract $connector
    ) {}

    public function getActions(
        ?int $id = null,
        ?string $status = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetActionsResponse {
        $request = ClientRequestBuilder::get('certificates/actions')
            ->withQueryParams([
                'page' => $page,
                'per_page' => $perPage,
                'sort' => $sort,
                'id' => $id,
                'status' => $status,
            ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetActionsResponseSchema $data */
        $data = $response->data();

        return GetActionsResponse::from($data);
    }

    public function getAction(int $id): GetActionResponse
    {
        $request = ClientRequestBuilder::get("certificates/actions/$id");

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetActionResponseSchema $data */
        $data = $response->data();

        return GetActionResponse::from($data);
    }

    public function getCertificateActions(
        int $id,
        ?string $status = null,
        ?string $sort = null,
        int $page = 1,
        int $perPage = 25
    ): GetActionsResponse {
        $request = ClientRequestBuilder::get("certificates/$id/actions")
            ->withQueryParams([
                'page' => $page,
                'per_page' => $perPage,
                'sort' => $sort,
                'status' => $status,
            ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetActionsResponseSchema $data */
        $data = $response->data();

        return GetActionsResponse::from($data);
    }

    public function getCertificateAction(int $certificateId, int $actionId): GetActionResponse
    {
        $request = ClientRequestBuilder::get("certificates/$certificateId/actions/$actionId");

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetActionResponseSchema $data */
        $data = $response->data();

        return GetActionResponse::from($data);
    }

    public function retryIssuanceOrRenewal(int $id): GetActionResponse
    {
        $request = ClientRequestBuilder::post("certificates/$id/actions/retry");

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetActionResponseSchema $data */
        $data = $response->data();

        return GetActionResponse::from($data);
    }
}
