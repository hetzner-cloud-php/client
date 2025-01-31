<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Models\Datacenter;
use HetznerCloud\Responses\Resources\Datacenters\GetDatacenterResponse;
use HetznerCloud\Testing\Fixtures\Datacenters\GetDatacenterFixture;

covers(GetDatacenterResponse::class);

describe(GetDatacenterResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetDatacenterResponse::from(GetDatacenterFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetDatacenterResponse::class)
            ->datacenter->not->toBeNull()->toBeInstanceOf(Datacenter::class)
            ->error->toBeNull();
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetDatacenterResponse::from(GetDatacenterFixture::data());

        // Assert
        expect($response['datacenter'])
            ->not->toBeNull()->toBeArray()
            ->and($response['error'])->toBeNull();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetDatacenterFixture::data();

        // Act
        $response = GetDatacenterResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->and($response['datacenter'])->toBeArray()
            ->and($response['error'])->toBeNull();
    });

    it('returns errors', function (): void {
        // Arrange
        $error = GetDatacenterFixture::error();

        // Act
        $response = GetDatacenterResponse::from($error);

        // Assert
        expect($response->error)
            ->not->toBeNull()->toBeInstanceOf(Error::class)
            ->and($response->toArray())
            ->toBeArray()
            ->toHaveKey('datacenter')
            ->toHaveKey('error')
            ->and($response['datacenter'])->toBeNull()
            ->and($response['error'])->toBeArray()
            ->toHaveKey('message')
            ->toHaveKey('code');
    });
});
