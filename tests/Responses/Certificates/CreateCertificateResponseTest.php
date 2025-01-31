<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Models\Certificate;
use HetznerCloud\Responses\Resources\Certificates\CreateCertificateResponse;
use HetznerCloud\Testing\Fixtures\Certificates\CreateCertificateFixture;

covers(CreateCertificateResponse::class);

describe(CreateCertificateResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = CreateCertificateResponse::from(CreateCertificateFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(CreateCertificateResponse::class)
            ->action->toBeInstanceOf(Action::class)
            ->certificate->toBeInstanceOf(Certificate::class);
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = CreateCertificateResponse::from(CreateCertificateFixture::data());

        // Assert
        expect($response['certificate'])->toBeArray()
            ->and($response['action'])->toBeArray();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = CreateCertificateFixture::data();

        // Act
        $response = CreateCertificateResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toHaveKeys(['action', 'certificate'])
            ->and($response['action'])
            ->toBeArray()
            ->toHaveKey('id')
            ->and($response['certificate'])
            ->toBeArray()
            ->toHaveKey('id');
    });

    it('returns errors', function (): void {
        // Arrange
        $error = CreateCertificateFixture::error();

        // Act
        $response = CreateCertificateResponse::from($error);

        // Assert
        expect($response->error)
            ->not->toBeNull()->toBeInstanceOf(Error::class)
            ->and($response->toArray())
            ->toBeArray()
            ->toHaveKey('action')
            ->toHaveKey('certificate')
            ->toHaveKey('error')
            ->and($response['action'])->toBeNull()
            ->and($response['certificate'])->toBeNull()
            ->and($response['error'])->toBeArray()
            ->toHaveKey('message')
            ->toHaveKey('code');
    });
});
