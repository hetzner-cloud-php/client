<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Connector\Response;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Servers\CreateServerResponse;
use Tests\Fixtures\Servers\CreateServerFixture;
use Tests\Mocks\ClientMock;

covers(ServersResource::class);

describe('servers', function (): void {
    it('can create a server for a project', function (): void {
        // Arrange
        $client = ClientMock::createForPost(
            'servers',
            [
                'name' => 'test-server',
                'image' => 'ubuntu-22.04',
                'server_type' => 'cpx11',
            ],
            Response::from(CreateServerFixture::data()),
        );

        // Act
        $result = $client->servers()->createServer(
            name: 'test-server',
            image: 'ubuntu-22.04',
            serverType: 'cpx11'
        );

        // Assert
        expect($result)
            ->toBeInstanceOf(CreateServerResponse::class)
            ->rootPassword->toBeString()
            ->action->toBeArray()
            ->nextActions->toBeArray()
            ->server->toBeArray();
    });
});
