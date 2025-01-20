<?php

declare(strict_types=1);

namespace HetznerCloud\Resources;

use HetznerCloud\Contracts\Resources\CertificatesResourceContract;
use HetznerCloud\Exceptions\NotImplementedException;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\HttpClientUtilities\Support\ClientRequestBuilder;
use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Responses\Certificates\CreateCertificateResponse;
use HetznerCloud\Responses\Certificates\GetCertificateResponse;
use HetznerCloud\Responses\Certificates\GetCertificatesResponse;

/**
 * @phpstan-import-type GetCertificatesResponseSchema from GetCertificatesResponse
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

    public function createCertificate(array $request): CreateCertificateResponse
    {
        throw new NotImplementedException;
    }

    public function deleteCertificate(int $id): void
    {
        throw new NotImplementedException;
    }

    public function getCertificate(int $id): GetCertificateResponse
    {
        throw new NotImplementedException;
    }

    public function updateCertificate(int $id, array $request): GetCertificateResponse
    {
        throw new NotImplementedException;
    }
}
