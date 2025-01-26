<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\CertificatesResource;
use HetznerCloud\Responses\Certificates\GetCertificateResponse;
use HetznerCloud\Responses\Certificates\Models\Certificate;
use HetznerCloud\Testing\Fixtures\Certificates\GetCertificateFixture;
use Tests\Mocks\ClientMock;

covers(CertificatesResource::class);

describe('certificate', function (): void {
    it('can update a certificate with minimal parameters', function (): void {
        // Arrange
        $client = ClientMock::put(
            'certificates/42069',
            [
                'name' => 'test-cert',
                'labels' => [
                    'foo' => 'bar',
                ],
            ],
            Response::from(GetCertificateFixture::data()),
        );

        // Act
        $result = $client->certificates()->updateCertificate(42069, [
            'name' => 'test-cert',
            'labels' => [
                'foo' => 'bar',
            ],
        ]);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetCertificateResponse::class)
            ->certificate->toBeInstanceOf(Certificate::class)
            ->error->toBeNull();
    });
});
