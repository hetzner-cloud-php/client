<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\CertificatesResource;
use HetznerCloud\Responses\Certificates\GetCertificateResponse;
use HetznerCloud\Responses\Certificates\Models\Certificate;
use HetznerCloud\Testing\Fixtures\Certificates\GetCertificateFixture;
use Tests\Mocks\ClientMock;

covers(CertificatesResource::class);

describe('certificates', function (): void {
    it('can retrieve a certificate for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/42069',
            Response::from(GetCertificateFixture::data())
        );

        // Act
        $result = $client->certificates()->getCertificate(42069);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetCertificateResponse::class)
            ->certificate->toBeInstanceOf(Certificate::class)
            ->error->toBeNull();
    });
});
