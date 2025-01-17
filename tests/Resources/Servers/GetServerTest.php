<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Servers\GetServerResponse;
use HetznerCloud\Responses\Servers\Models\Server;
use Tests\Fixtures\Servers\GetServerFixture;
use Tests\Mocks\ClientMock;

covers(ServersResource::class);

describe('servers', function (): void {
    it('can retrieve a single server from a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'servers/42069',
            Response::from(GetServerFixture::data()),
        );

        // Act
        $result = $client->servers()->getServer(42069);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetServerResponse::class)
            ->server->toBeInstanceOf(Server::class);
    });
});
