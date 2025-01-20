<?php

declare(strict_types=1);

use HetznerCloud\Client;
use HetznerCloud\Contracts\Resources\ActionsResourceContract;
use HetznerCloud\Contracts\Resources\CertificatesResourceContract;
use HetznerCloud\Contracts\Resources\ServersResourceContract;
use HetznerCloud\HttpClientUtilities\Contracts\ConnectorContract;
use HetznerCloud\Resources\ActionsResource;
use HetznerCloud\Resources\CertificatesResource;
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

    it('provides access to the servers resources', function (): void {
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

    it('provides access to the actions resources', function (): void {
        // Arrange
        $connector = Mockery::mock(ConnectorContract::class);
        $client = new Client($connector);

        // Act
        $serversResource = $client->actions();

        // Assert
        expect($serversResource)
            ->toBeInstanceOf(ActionsResourceContract::class)
            ->toBeInstanceOf(ActionsResource::class);
    });

    it('provides access to the certificates resources', function (): void {
        // Arrange
        $connector = Mockery::mock(ConnectorContract::class);
        $client = new Client($connector);

        // Act
        $serversResource = $client->certificates();

        // Assert
        expect($serversResource)
            ->toBeInstanceOf(CertificatesResourceContract::class)
            ->toBeInstanceOf(CertificatesResource::class);
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
