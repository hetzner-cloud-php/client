<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Servers\CreateServerResponse;
use HetznerCloud\ValueObjects\Actions\Action;
use HetznerCloud\ValueObjects\Servers\Server;
use Tests\Fixtures\Servers\CreateServerFixture;
use Tests\Mocks\ClientMock;

covers(ServersResource::class);

describe('servers', function (): void {
    it('can create a server with minimal parameters', function (): void {
        // Arrange
        $client = ClientMock::post(
            'servers',
            [
                'name' => 'test-server',
                'image' => 'ubuntu-22.04',
                'server_type' => 'cpx11',
            ],
            Response::from(CreateServerFixture::data()),
        );

        // Act
        $result = $client->servers()->createServer([
            'name' => 'test-server',
            'image' => 'ubuntu-22.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        expect($result)
            ->toBeInstanceOf(CreateServerResponse::class)
            ->rootPassword->toBeString()
            ->action->toBeInstanceOf(Action::class)
            ->nextActions->toBeArray()->each->toBeInstanceOf(Action::class)
            ->server->toBeInstanceOf(Server::class);
    });

    it('can create a server with all optional parameters', function (): void {
        // Arrange
        $expectedPayload = [
            'name' => 'test-server',
            'image' => 'ubuntu-22.04',
            'server_type' => 'cpx11',
            'automount' => true,
            'start_after_create' => true,
            'volumes' => ['vol1', 'vol2'],
            'datacenter' => 'nbg1-dc3',
            'firewalls' => ['fw1', 'fw2'],
            'labels' => ['env' => 'prod'],
            'location' => 'nbg1',
            'networks' => ['net1', 'net2'],
            'placement_group' => 123,
            'public_net' => ['enable_ipv4' => true],
            'ssh_keys' => ['key1', 'key2'],
            'user_data' => 'cloud-init-data',
        ];

        $client = ClientMock::post(
            'servers',
            $expectedPayload,
            Response::from(CreateServerFixture::data()),
        );

        // Act
        $result = $client->servers()->createServer([
            'name' => 'test-server',
            'image' => 'ubuntu-22.04',
            'server_type' => 'cpx11',
            'automount' => true,
            'start_after_create' => true,
            'volumes' => [
                'vol1',
                'vol2',
            ],
            'datacenter' => 'nbg1-dc3',
            'firewalls' => [
                'fw1', 'fw2',
            ],
            'labels' => [
                'env' => 'prod',
            ],
            'location' => 'nbg1',
            'networks' => [
                'net1',
                'net2',
            ],
            'placement_group' => 123,
            'public_net' => [
                'enable_ipv4' => true,
            ],
            'ssh_keys' => [
                'key1',
                'key2',
            ],
            'user_data' => 'cloud-init-data',
        ]);

        // Assert
        expect($result)->toBeInstanceOf(CreateServerResponse::class);
    });
});
