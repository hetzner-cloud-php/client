<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\Response;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Servers\GetServerResponse;
use Tests\Mocks\ClientMock;

use function Tests\Fixtures\Servers\server;

covers(ServersResource::class);

describe('servers', function (): void {
    it('can retrieve a single server from a project', function (): void {
        // Arrange
        $client = ClientMock::createForGet(
            'servers/42069',
            Response::from(server()),
        );

        // Act
        $result = $client->servers()->getServer(42069);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetServerResponse::class)
            ->server->toBeArray();
    });
});
