<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Certificates\GetCertificatesResponse;
use HetznerCloud\Responses\Certificates\Models\Certificate;
use HetznerCloud\Responses\Meta;
use HetznerCloud\Testing\Fixtures\Certificates\GetCertificatesFixture;

covers(GetCertificatesResponse::class);

describe(GetCertificatesResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetCertificatesResponse::from(GetCertificatesFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetCertificatesResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->certificates->toBeArray()->each->toBeInstanceOf(Certificate::class);
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetCertificatesResponse::from(GetCertificatesFixture::data());

        // Assert
        expect($response['meta'])->toBeArray()
            ->and($response['certificates'])->toBeArray();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetCertificatesFixture::data();

        // Act
        $response = GetCertificatesResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toHaveKey('meta')
            ->toHaveKey('certificates')
            ->and($response['certificates'])
            ->toBeArray()
            ->each->toBeArray()->toHaveKey('id');
    });
});
