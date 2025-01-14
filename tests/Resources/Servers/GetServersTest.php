<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Servers\GetServersResponse;
use Tests\Fixtures\Servers\GetServersFixture;
use Tests\Mocks\ClientMock;

covers(ServersResource::class);

describe('servers', function (): void {
    it('can retrieve servers for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'servers',
            Response::from(GetServersFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->servers()->getServers();

        // Assert
        expect($result)
            ->toBeInstanceOf(GetServersResponse::class)
            ->meta->toBeArray()
            ->servers->toBeArray();
    });

    it('can retrieve servers from a page', function (): void {
        // Arrange
        $client = ClientMock::get(
            'servers',
            Response::from(GetServersFixture::data()),
            [
                'page' => 2,
                'per_page' => 25,
            ],
        );

        // Act
        $result = $client->servers()->getServers(page: 2);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetServersResponse::class)
            ->meta->toBeArray()
            ->servers->toBeArray();
    });

    it('can retrieve servers with a per page parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'servers',
            Response::from(GetServersFixture::data()),
            [
                'page' => 1,
                'per_page' => 69,
            ],
        );

        // Act
        $result = $client->servers()->getServers(perPage: 69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetServersResponse::class)
            ->meta->toBeArray()
            ->servers->toBeArray();
    });
});
