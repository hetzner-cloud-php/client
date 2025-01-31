<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Models\Certificate;
use HetznerCloud\Responses\Resources\Certificates\GetCertificateResponse;
use HetznerCloud\Testing\Fixtures\Certificates\GetCertificateFixture;

covers(GetCertificateResponse::class);

describe(GetCertificateResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetCertificateResponse::from(GetCertificateFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetCertificateResponse::class)
            ->certificate->toBeInstanceOf(Certificate::class)
            ->error->toBeNull();
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetCertificateResponse::from(GetCertificateFixture::data());

        // Assert
        expect($response['certificate'])->toBeArray()
            ->and($response['error'])->toBeNull();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetCertificateFixture::data();

        // Act
        $response = GetCertificateResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toHaveKey('certificate')
            ->toHaveKey('error')
            ->and($response['error'])->toBeNull()
            ->and($response['certificate'])
            ->toBeArray()
            ->toHaveKey('id')
            ->toHaveKey('certificate');
    });

    it('returns errors', function (): void {
        // Arrange
        $error = GetCertificateFixture::error();

        // Act
        $response = GetCertificateResponse::from($error);

        // Assert
        expect($response->error)
            ->not->toBeNull()->toBeInstanceOf(Error::class)
            ->and($response->toArray())
            ->toBeArray()
            ->toHaveKey('certificate')
            ->toHaveKey('error')
            ->and($response['certificate'])->toBeNull()
            ->and($response['error'])->toBeArray()
            ->toHaveKey('message')
            ->toHaveKey('code');
    });
});
