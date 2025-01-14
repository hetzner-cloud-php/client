<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Servers\GetServerMetricsResponse;
use Tests\Fixtures\Servers\GetServerMetricsFixture;

covers(GetServerMetricsResponse::class);

describe(GetServerMetricsResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetServerMetricsResponse::from(GetServerMetricsFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetServerMetricsResponse::class)
            ->metrics->toBeArray();
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetServerMetricsResponse::from(GetServerMetricsFixture::data());

        // Assert
        expect($response['metrics'])->toBeArray();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetServerMetricsFixture::data();

        // Act
        $response = GetServerMetricsResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toBe($data);
    });
});
