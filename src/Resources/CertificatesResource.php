<?php

declare(strict_types=1);

namespace HetznerCloud\Resources;

use HetznerCloud\Contracts\Resources\CertificateActionsResourceContract;
use HetznerCloud\Contracts\Resources\CertificatesResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Support\ClientRequestBuilder;
use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Responses\Resources\Certificates\CreateCertificateResponse;
use HetznerCloud\Responses\Resources\Certificates\GetCertificateResponse;
use HetznerCloud\Responses\Resources\Certificates\GetCertificatesResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @phpstan-import-type GetCertificateResponseSchema from GetCertificateResponse
 * @phpstan-import-type GetCertificatesResponseSchema from GetCertificatesResponse
 * @phpstan-import-type CreateCertificateResponseSchema from CreateCertificateResponse
 */
final readonly class CertificatesResource implements CertificatesResourceContract
{
    public function __construct(
        public ConnectorContract $connector
    ) {
        //
    }

    public function getCertificates(
        ?string $sort = null,
        ?string $name = null,
        ?string $labelSelector = null,
        ?string $type = null,
        int $page = 1,
        int $perPage = 25
    ): GetCertificatesResponse {
        $request = ClientRequestBuilder::get('certificates')
            ->withQueryParams([
                'page' => $page,
                'per_page' => $perPage,
                'sort' => $sort,
                'name' => $name,
                'label_selector' => $labelSelector,
                'type' => $type,
            ]);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetCertificatesResponseSchema $data */
        $data = $response->data();

        return GetCertificatesResponse::from($data);
    }

    /**
     * @param array{
     *     name: string,
     *     certificate?: string,
     *     domain_names?: string[],
     *     labels?: array<string, string>,
     *     private_key?: string,
     *     type?: string
     * } $request
     */
    public function createCertificate(array $request): CreateCertificateResponse
    {
        $request = ClientRequestBuilder::post('certificates')
            ->withRequestContent($request);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var CreateCertificateResponseSchema $data */
        $data = $response->data();

        return CreateCertificateResponse::from($data);
    }

    public function deleteCertificate(int $id): ResponseInterface
    {
        $request = ClientRequestBuilder::delete("certificates/$id");

        return $this->connector->sendStandardClientRequest($request);
    }

    public function getCertificate(int $id): GetCertificateResponse
    {
        $request = ClientRequestBuilder::get("certificates/$id");

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetCertificateResponseSchema $data */
        $data = $response->data();

        return GetCertificateResponse::from($data);
    }

    /**
     * @param array{
     *     name?: string,
     *     labels?: array<string, string>
     * } $request
     */
    public function updateCertificate(int $id, array $request): GetCertificateResponse
    {
        $request = ClientRequestBuilder::put("certificates/$id")
            ->withRequestContent($request);

        /** @var Response<array<array-key, mixed>> $response */
        $response = $this->connector->sendClientRequest($request);

        /** @var GetCertificateResponseSchema $data */
        $data = $response->data();

        return GetCertificateResponse::from($data);
    }

    public function actions(): CertificateActionsResourceContract
    {
        return new CertificateActionsResource($this->connector);
    }
}
