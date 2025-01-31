<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\CertificatesResource;
use HetznerCloud\Responses\Models\Certificate;
use HetznerCloud\Responses\Models\Meta;
use HetznerCloud\Responses\Resources\Certificates\GetCertificatesResponse;
use HetznerCloud\Testing\Fixtures\Certificates\GetCertificatesFixture;
use Tests\Mocks\ClientMock;

covers(CertificatesResource::class);

describe('certificates', function (): void {
    it('can retrieve certificates for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates',
            Response::from(GetCertificatesFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->certificates()->getCertificates();

        // Assert
        expect($result)
            ->toBeInstanceOf(GetCertificatesResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->certificates->toBeArray()->each->toBeInstanceOf(Certificate::class);
    });

    it('can retrieve certificates from a page', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates',
            Response::from(GetCertificatesFixture::data()),
            [
                'page' => 69,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->certificates()->getCertificates(page: 69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetCertificatesResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->certificates->toBeArray()->each->toBeInstanceOf(Certificate::class);
    });

    it('can retrieve certificates with per page param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates',
            Response::from(GetCertificatesFixture::data()),
            [
                'page' => 1,
                'per_page' => 420,
            ]
        );

        // Act
        $result = $client->certificates()->getCertificates(perPage: 420);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetCertificatesResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->certificates->toBeArray()->each->toBeInstanceOf(Certificate::class);
    });

    it('can retrieve certificates with sort param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates',
            Response::from(GetCertificatesFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'sort' => 'name:asc',
            ]
        );

        // Act
        $result = $client->certificates()->getCertificates(sort: 'name:asc');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetCertificatesResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->certificates->toBeArray()->each->toBeInstanceOf(Certificate::class);
    });

    it('can retrieve certificates with name param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates',
            Response::from(GetCertificatesFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'name' => 'test-cert',
            ]
        );

        // Act
        $result = $client->certificates()->getCertificates(name: 'test-cert');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetCertificatesResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->certificates->toBeArray()->each->toBeInstanceOf(Certificate::class);
    });

    it('can retrieve certificates with label selector param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates',
            Response::from(GetCertificatesFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'label_selector' => 'foo',
            ]
        );

        // Act
        $result = $client->certificates()->getCertificates(labelSelector: 'foo');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetCertificatesResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->certificates->toBeArray()->each->toBeInstanceOf(Certificate::class);
    });

    it('can retrieve certificates with type param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates',
            Response::from(GetCertificatesFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'type' => 'bar',
            ]
        );

        // Act
        $result = $client->certificates()->getCertificates(type: 'bar');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetCertificatesResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->certificates->toBeArray()->each->toBeInstanceOf(Certificate::class);
    });
});
