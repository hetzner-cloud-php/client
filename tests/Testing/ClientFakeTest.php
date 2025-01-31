<?php

declare(strict_types=1);

namespace Tests\Testing;

use Exception;
use HetznerCloud\Exceptions\HetznerCloudException;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Servers\CreateServerResponse;
use HetznerCloud\Responses\Servers\Models\Server;
use HetznerCloud\Testing\ClientFake;
use HetznerCloud\Testing\Fixtures\ErrorFixture;
use PHPUnit\Framework\ExpectationFailedException;

covers(ClientFake::class);

describe(ClientFake::class, function () {
    it('returns fake data', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act
        $response = $fake->servers()->createServer([
            'name' => 'test-response',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Act
        expect($response)->toBeInstanceOf(CreateServerResponse::class)
            ->nextActions->toBeArray()->each->toBeInstanceOf(Action::class)
            ->rootPassword->toBeString()
            ->server->toBeInstanceOf(Server::class)
            ->action->toBeInstanceOf(Action::class);
    });

    it('throws fake exceptions', function () {
        // Arrange
        $fake = new ClientFake([
            HetznerCloudException::from([
                'error' => ErrorFixture::data(),
            ], 400),
        ]);

        // Act & Assert
        $fake->servers()->createServer([
            'name' => 'test-response',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);
    })->throws(HetznerCloudException::class);

    it('throws an exception if there are no more fake responses', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'test-response',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Act again
        $fake->servers()->createServer([
            'name' => 'test-response',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cx11',
        ]);
    })->throws(Exception::class, 'No fake responses left');

    it('allows to add more responses', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake([
                'server' => [
                    'name' => 'fake-server',
                ],
            ]),
        ]);

        // Act
        $response = $fake->servers()->createServer([
            'name' => 'fake-server',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        expect($response)->toBeInstanceOf(CreateServerResponse::class)
            ->nextActions->toBeArray()->each->toBeInstanceOf(Action::class)
            ->rootPassword->toBeString()
            ->server->toBeInstanceOf(Server::class)
            ->action->toBeInstanceOf(Action::class)
            ->and($response->server?->name)->toBe('fake-server');

        // Act again, simulate another response going through
        $fake->addResponses([
            CreateServerResponse::fake([
                'server' => [
                    'name' => 'another-fake-server',
                ],
            ]),
        ]);

        $response = $fake->servers()->createServer([
            'name' => 'another-fake-server',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        expect($response)->toBeInstanceOf(CreateServerResponse::class)
            ->nextActions->toBeArray()->each->toBeInstanceOf(Action::class)
            ->rootPassword->toBeString()
            ->server->toBeInstanceOf(Server::class)
            ->action->toBeInstanceOf(Action::class)
            ->and($response->server?->name)->toBe('another-fake-server');
    });

    it('asserts a request was sent', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'fake-server',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        $fake->assertSent(ServersResource::class, function (string $method, array $parameters) {
            return $method === 'createServer' &&
                $parameters['name'] === 'fake-server' &&
                $parameters['image'] === 'Ubuntu 24.04' &&
                $parameters['server_type'] === 'cpx11';
        });
    });

    it('throws an exception if a request was not sent', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act & Assert
        $fake->assertSent(ServersResource::class, function (string $method, array $parameters) {
            return $method === 'createServer' &&
                $parameters['name'] === 'fake-server' &&
                $parameters['image'] === 'Ubuntu 24.04' &&
                $parameters['server_type'] === 'cpx11';
        });
    })->throws(ExpectationFailedException::class);

    it('asserts a request was sent on the resource', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'fake-server',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        $fake->servers()->assertSent(function (string $method, array $parameters) {
            return $method === 'createServer' &&
                $parameters['name'] === 'fake-server' &&
                $parameters['image'] === 'Ubuntu 24.04' &&
                $parameters['server_type'] === 'cpx11';
        });
    });

    it('asserts a request was sent any number of times', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'fake-server',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        $fake->servers()->createServer([
            'name' => 'fake-server',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        $fake->assertSent(ServersResource::class, 2);
    });

    it('throws an exception if a request was not sent any number of times', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'fake-server',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        $fake->assertSent(ServersResource::class, 2);
    })->throws(ExpectationFailedException::class);

    it('asserts a request was not sent', function () {
        // Arrange
        $fake = new ClientFake;

        // Act & Assert
        $fake->assertNotSent(ServersResource::class);
    });

    it('throws an exception if an unexpected request was sent', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'fake-server',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        $fake->assertNotSent(ServersResource::class);
    })->throws(ExpectationFailedException::class);

    it('asserts a request was not sent on the resource', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act & Assert
        $fake->servers()->assertNotSent();
    });

    it('asserts no request was sent', function () {
        // Arrange
        $fake = new ClientFake;

        // Act & Assert
        $fake->assertNothingSent();
    });

    it('throws an exception if any request was sent when non was expected', function () {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'fake-server',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        $fake->assertNothingSent();
    })->throws(ExpectationFailedException::class);
});
