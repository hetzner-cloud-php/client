<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Models\Server;
use HetznerCloud\Responses\Resources\Servers\CreateServerResponse;
use HetznerCloud\Testing\Fixtures\Servers\CreateServerFixture;

covers(CreateServerResponse::class);

describe(CreateServerResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = CreateServerResponse::from(CreateServerFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(CreateServerResponse::class)
            ->nextActions->toBeArray()->each->toBeInstanceOf(Action::class)
            ->action->toBeInstanceOf(Action::class)
            ->rootPassword->tobeString()
            ->server->toBeInstanceOf(Server::class);
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = CreateServerResponse::from(CreateServerFixture::data());

        // Assert
        expect($response['server'])->toBeArray()
            ->and($response['action'])->toBeArray()
            ->and($response['next_actions'])->toBeArray()
            ->and($response['root_password'])->tobeString();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = CreateServerFixture::data();

        // Act
        $response = CreateServerResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toHaveKeys(['action', 'next_actions', 'root_password', 'server'])
            ->and($response['action'])
            ->toBeArray()
            ->toHaveKey('id')
            ->and($response['next_actions'])
            ->toBeArray()->each->toBeArray()->toHaveKey('id')
            ->and($response['root_password'])
            ->toBeString()
            ->and($response['server'])
            ->toBeArray()
            ->toHaveKey('id');
    });

    it('returns errors', function (): void {
        // Arrange
        $error = CreateServerFixture::error();

        // Act
        $response = CreateServerResponse::from($error);

        // Assert
        expect($response->error)
            ->not->toBeNull()->toBeInstanceOf(Error::class)
            ->and($response->toArray())
            ->toBeArray()
            ->toHaveKey('action')
            ->toHaveKey('next_actions')
            ->toHaveKey('root_password')
            ->toHaveKey('error')
            ->toHaveKey('server')
            ->and($response['action'])->toBeNull()
            ->and($response['next_actions'])->toBeArray()->toBeEmpty()
            ->and($response['root_password'])->toBeNull()
            ->and($response['server'])->toBeNull()
            ->and($response['error'])->toBeArray()
            ->toHaveKey('message')
            ->toHaveKey('code');
    });

    it('transforms response with next actions to array', function (): void {
        // Arrange
        $data = CreateServerFixture::data();

        // Act
        $response = CreateServerResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toHaveKey('next_actions')
            ->and($response['next_actions'])
            ->toBeArray()
            ->not->toBeEmpty()
            ->each->toBeArray()->toHaveKey('id');
    });

    it('generates fake responses', function (): void {
        // Arrange & Act
        $fake = CreateServerResponse::fake(CreateServerFixture::class);

        // Assert
        expect($fake)->toBeInstanceOf(CreateServerResponse::class)
            ->nextActions->toBeArray()->each->toBeInstanceOf(Action::class)
            ->action->toBeInstanceOf(Action::class)
            ->rootPassword->toBeString()
            ->server->toBeInstanceOf(Server::class);
    });

    it('can override properties on fakes', function (): void {
        // Arrange & Act
        $fake = CreateServerResponse::fake(CreateServerFixture::class, [
            'root_password' => 'password123',
        ]);

        // Assert
        expect($fake)->toBeInstanceOf(CreateServerResponse::class)
            ->nextActions->toBeArray()->each->toBeInstanceOf(Action::class)
            ->action->toBeInstanceOf(Action::class)
            ->rootPassword->toBeString('password123')
            ->server->toBeInstanceOf(Server::class);
    });

    it('can override nested properties on fakes', function (): void {
        // Arrange & Act
        $fake = CreateServerResponse::fake(CreateServerFixture::class, [
            'root_password' => 'password123',
            'action' => [
                'command' => 'stop_resource',
            ],
        ]);

        // Assert
        expect($fake)->toBeInstanceOf(CreateServerResponse::class)
            ->nextActions->toBeArray()->each->toBeInstanceOf(Action::class)
            ->rootPassword->toBe('password123')
            ->server->toBeInstanceOf(Server::class)
            ->action->toBeInstanceOf(Action::class)
            ->and($fake->action?->command)->toBe('stop_resource');
    });
});
