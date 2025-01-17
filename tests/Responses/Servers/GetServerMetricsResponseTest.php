<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Servers\GetServerMetricsResponse;
use HetznerCloud\Responses\Servers\Models\Metrics;
use HetznerCloud\Responses\Servers\Models\TimeSeries;
use Tests\Fixtures\Servers\GetServerMetricsFixture;

covers(GetServerMetricsResponse::class);

describe(GetServerMetricsResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetServerMetricsResponse::from(GetServerMetricsFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetServerMetricsResponse::class)
            ->metrics->toBeInstanceOf(Metrics::class)
            ->metrics->timeSeries->each->toBeInstanceOf(TimeSeries::class);
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
            ->toHaveKey('metrics')
            ->toHaveKey('error')
            ->and($response['metrics'])->toBeArray()
            ->and($response['error'])->toBeNull();
    });

    it('returns errors', function (): void {
        // Arrange
        $error = GetServerMetricsFixture::error();

        // Act
        $response = GetServerMetricsResponse::from($error);

        // Assert
        expect($response->error)
            ->not->toBeNull()->toBeInstanceOf(Error::class)
            ->and($response->toArray())
            ->toBeArray()
            ->toHaveKey('metrics')
            ->toHaveKey('error')
            ->and($response['metrics'])->toBeNull()
            ->and($response['error'])->toBeArray()
            ->toHaveKey('message')
            ->toHaveKey('code');
    });
});
