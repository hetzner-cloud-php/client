<?php

declare(strict_types=1);

namespace HetznerCloud\Contracts\Resources;

use HetznerCloud\Responses\Resources\Certificates\CreateCertificateResponse;
use HetznerCloud\Responses\Resources\Certificates\GetCertificateResponse;
use HetznerCloud\Responses\Resources\Certificates\GetCertificatesResponse;
use Psr\Http\Message\ResponseInterface;

interface CertificatesResourceContract
{
    public function getCertificates(
        ?string $sort = null,
        ?string $name = null,
        ?string $labelSelector = null,
        ?string $type = null,
        int $page = 1,
        int $perPage = 25
    ): GetCertificatesResponse;

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
    public function createCertificate(array $request): CreateCertificateResponse;

    public function deleteCertificate(int $id): ResponseInterface;

    public function getCertificate(int $id): GetCertificateResponse;

    /**
     * @param array{
     *     name?: string,
     *     labels?: array<string, string>
     * } $request
     */
    public function updateCertificate(int $id, array $request): GetCertificateResponse;

    public function actions(): CertificateActionsResourceContract;
}
