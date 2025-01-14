<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Servers\GetServerMetricsResponse;
use Tests\Fixtures\Servers\GetServerMetricsFixture;
use Tests\Mocks\ClientMock;

covers(ServersResource::class);

describe('servers', function (): void {
    it('can retrieve metrics for a server', function (): void {
        // Arrange
        $start = Carbon\Carbon::now()->subDays();
        $end = Carbon\Carbon::now();
        $client = ClientMock::get(
            'servers/42069/metrics',
            Response::from(GetServerMetricsFixture::data()),
            [
                'type' => ['disk'],
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
            ],
        );

        // Act
        $result = $client->servers()->getServerMetrics(42069, ['disk'], $start, $end);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetServerMetricsResponse::class)
            ->metrics->toBeArray();
    });

    it('can retrieve multiple metrics for a server', function (): void {
        // Arrange
        $start = Carbon\Carbon::now()->subDays();
        $end = Carbon\Carbon::now();
        $client = ClientMock::get(
            'servers/42069/metrics',
            Response::from(GetServerMetricsFixture::data()),
            [
                'type' => ['disk', 'cpu'],
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
            ],
        );

        // Act
        $result = $client->servers()->getServerMetrics(42069, ['disk', 'cpu'], $start, $end);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetServerMetricsResponse::class)
            ->metrics->toBeArray();
    });

    it('can retrieve metrics for a server with a step', function (): void {
        // Arrange
        $start = Carbon\Carbon::now()->subDays();
        $end = Carbon\Carbon::now();
        $client = ClientMock::get(
            'servers/420/metrics',
            Response::from(GetServerMetricsFixture::data()),
            [
                'type' => ['disk', 'cpu'],
                'start' => $start->toIso8601String(),
                'end' => $end->toIso8601String(),
                'step' => 69,
            ],
        );

        // Act
        $result = $client->servers()->getServerMetrics(420, ['disk', 'cpu'], $start, $end, 69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetServerMetricsResponse::class)
            ->metrics->toBeArray();
    });
});
