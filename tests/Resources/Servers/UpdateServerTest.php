<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Models\Server;
use HetznerCloud\Responses\Resources\Servers\GetServerResponse;
use HetznerCloud\Testing\Fixtures\Servers\GetServerFixture;
use Tests\Mocks\ClientMock;

covers(ServersResource::class);

describe('servers', function (): void {
    it('can update a server for a project', function (): void {
        // Arrange
        $client = ClientMock::put(
            'servers/42069',
            [
                'name' => 'test-server-1',
                'labels' => [
                    'foo' => 'bar',
                ],
            ],
            Response::from(GetServerFixture::data()),
        );

        // Act
        $result = $client->servers()->updateServer(42069, [
            'name' => 'test-server-1',
            'labels' => [
                'foo' => 'bar',
            ],
        ]);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetServerResponse::class)
            ->server->toBeInstanceOf(Server::class);
    });
});
