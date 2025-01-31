<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Models\Datacenter;
use HetznerCloud\Responses\Models\Meta;
use HetznerCloud\Responses\Resources\Datacenters\GetDatacentersResponse;
use HetznerCloud\Testing\Fixtures\Datacenters\GetDatacentersFixture;

covers(GetDatacentersResponse::class);

describe(GetDatacentersResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetDatacentersResponse::from(GetDatacentersFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetDatacentersResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->datacenters->toBeArray()->each->toBeInstanceOf(Datacenter::class)
            ->recommendation->toBeInt();
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetDatacentersResponse::from(GetDatacentersFixture::data());

        // Assert
        expect($response['meta'])->toBeArray()
            ->and($response['datacenters'])->toBeArray()
            ->and($response['recommendation'])->toBeInt();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetDatacentersFixture::data();

        // Act
        $response = GetDatacentersResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toHaveKey('meta')
            ->toHaveKey('datacenters')
            ->and($response['datacenters'])
            ->toBeArray()
            ->each->toBeArray()->toHaveKey('id');
    });
});
