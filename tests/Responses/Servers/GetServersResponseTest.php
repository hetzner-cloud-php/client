<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Servers\GetServersResponse;
use Tests\Fixtures\Servers\GetServersFixture;

covers(GetServersResponse::class);

describe(GetServersResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetServersResponse::from(GetServersFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetServersResponse::class)
            ->meta->toBeArray()
            ->servers->toBeArray();
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetServersResponse::from(GetServersFixture::data());

        // Assert
        expect($response['meta'])->toBeArray()
            ->and($response['servers'])->toBeArray();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetServersFixture::data();

        // Act
        $response = GetServersResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toBe($data);
    });
});
