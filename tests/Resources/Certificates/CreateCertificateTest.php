<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\CertificatesResource;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Models\Certificate;
use HetznerCloud\Responses\Resources\Certificates\CreateCertificateResponse;
use HetznerCloud\Testing\Fixtures\Certificates\CreateCertificateFixture;
use Tests\Mocks\ClientMock;

covers(CertificatesResource::class);

describe('certificate', function (): void {
    it('can create a certificate with minimal parameters', function (): void {
        // Arrange
        $client = ClientMock::post(
            'certificates',
            [
                'name' => 'test-cert',
            ],
            Response::from(CreateCertificateFixture::data()),
        );

        // Act
        $result = $client->certificates()->createCertificate([
            'name' => 'test-cert',
        ]);

        // Assert
        expect($result)
            ->toBeInstanceOf(CreateCertificateResponse::class)
            ->certificate->toBeInstanceOf(Certificate::class)
            ->action->toBeInstanceOf(Action::class);
    });

    it('can create a server with all optional parameters', function (): void {
        // Arrange
        $client = ClientMock::post(
            'certificates',
            [
                'name' => 'test-cert',
                'sort' => 'name:asc',
                'label_selector' => [
                    'foo' => 'bar',
                ],
                'type' => 'certificate',
            ],
            Response::from(CreateCertificateFixture::data()),
        );

        // Act
        $result = $client->certificates()->createCertificate([
            'name' => 'test-cert',
            'sort' => 'name:asc',
            'label_selector' => [
                'foo' => 'bar',
            ],
            'type' => 'certificate',
        ]);

        // Assert
        expect($result)->toBeInstanceOf(CreateCertificateResponse::class);
    });
});
