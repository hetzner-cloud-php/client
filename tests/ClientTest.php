<?php

declare(strict_types=1);

use HetznerCloud\Client;
use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\Resources\ServersResource;

covers(Client::class);

describe('Client', function (): void {
    it('can be instantiated with a connector', function (): void {
        // Arrange
        $connector = Mockery::mock(ConnectorContract::class);

        // Act
        $client = new Client($connector);

        // Assert
        expect($client)
            ->toBeInstanceOf(Client::class)
            ->connector->toBe($connector);
    });

    it('provides access to the servers resource', function (): void {
        // Arrange
        $connector = Mockery::mock(ConnectorContract::class);
        $client = new Client($connector);

        // Act
        $serversResource = $client->servers();

        // Assert
        expect($serversResource)
            ->toBeInstanceOf(ServersResourceContract::class)
            ->toBeInstanceOf(ServersResource::class);
    });

    it('provides a consistent servers resource instance with the same connector', function (): void {
        // Arrange
        $connector = Mockery::mock(ConnectorContract::class);
        $client = new Client($connector);

        // Act
        $resource1 = $client->servers();
        $resource2 = $client->servers();

        // Assert
        expect($resource1)->connector->toBe($connector);
        expect($resource2)
            ->connector->toBe($connector)
            ->and($resource1)->not->toBe($resource2);
    });

    it('has the correct API base URL defined', function (): void {
        // Assert
        expect(Client::API_BASE_URL)
            ->toBe('https://api.hetzner.cloud/v1');
    });
});
