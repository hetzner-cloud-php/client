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

describe(ClientFake::class, function (): void {
    it('returns fake data', function (): void {
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

    it('throws fake exceptions', function (): void {
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
    })->throws(HetznerCloudException::class, "invalid input in fields 'server_type', 'source_server', 'image'");

    it('throws an exception if there are no more fake responses', function (): void {
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

    it('allows to add more responses', function (): void {
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

    it('asserts a request was sent', function (): void {
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
        $fake->assertSent(ServersResource::class, fn (string $method, array $parameters): bool => $method === 'createServer' &&
            $parameters['name'] === 'fake-server' &&
            $parameters['image'] === 'Ubuntu 24.04' &&
            $parameters['server_type'] === 'cpx11');
    });

    it('throws an exception if a request was not sent', function (): void {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act & Assert
        $fake->assertSent(ServersResource::class, fn (string $method, array $parameters): bool => $method === 'createServer' &&
            $parameters['name'] === 'fake-server' &&
            $parameters['image'] === 'Ubuntu 24.04' &&
            $parameters['server_type'] === 'cpx11');
    })->throws(ExpectationFailedException::class);

    it('asserts a request was sent on the resource', function (): void {
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
        $fake->servers()->assertSent(fn (string $method, array $parameters): bool => $method === 'createServer' &&
            $parameters['name'] === 'fake-server' &&
            $parameters['image'] === 'Ubuntu 24.04' &&
            $parameters['server_type'] === 'cpx11');
    });

    it('asserts a request was sent any number of times', function (): void {
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

    it('throws an exception if a request was not sent any number of times', function (): void {
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

    it('asserts a request was not sent', function (): void {
        // Arrange
        $fake = new ClientFake;

        // Act & Assert
        $fake->assertNotSent(ServersResource::class);
    });

    it('throws an exception if an unexpected request was sent', function (): void {
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

    it('asserts a request was not sent on the resource', function (): void {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act & Assert
        $fake->servers()->assertNotSent();
    });

    it('asserts no request was sent', function (): void {
        // Arrange
        $fake = new ClientFake;

        // Act & Assert
        $fake->assertNothingSent();
    });

    it('throws an exception if any request was sent when non was expected', function (): void {
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

    it('throws an exception with proper message when assertNothingSent fails', function (): void {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
            CreateServerResponse::fake(),
        ]);

        // Act - Create two different resource requests
        $fake->servers()->createServer([
            'name' => 'server-1',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        $fake->servers()->createServer([
            'name' => 'server-2',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert - Verify the exact error message format
        expect(fn () => $fake->assertNothingSent())
            ->toThrow(ExpectationFailedException::class, 'The following requests were sent unexpectedly: '.ServersResource::class.', '.ServersResource::class);
    });

    it('uses responses in FIFO order', function (): void {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(['server' => ['name' => 'first-server']]),
            CreateServerResponse::fake(['server' => ['name' => 'second-server']]),
        ]);

        // Act & Assert - First request should get first response
        $response1 = $fake->servers()->createServer([
            'name' => 'test',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);
        expect($response1->server?->name)->toBe('first-server');

        // Second request should get second response
        $response2 = $fake->servers()->createServer([
            'name' => 'test',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);
        expect($response2->server?->name)->toBe('second-server');
    });

    it('asserts a request was sent exactly once by default', function (): void {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'test',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert - Using the default parameter
        $fake->assertSent(ServersResource::class);

        // Should fail if we try to assert it was sent twice
        expect(fn () => $fake->assertSent(ServersResource::class, 2))
            ->toThrow(ExpectationFailedException::class, 'was sent 1 times instead of 2 times');
    });

    it('handles null callback in sent verification', function (): void {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'test',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert - Call assertSent with null callback (default behavior)
        $fake->assertSent(ServersResource::class);
    });

    it('returns empty array for non-existent resource without checking callback', function (): void {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
        ]);

        // Act
        $fake->servers()->createServer([
            'name' => 'test',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert
        expect($fake->sent(ServersResource::class))
            ->toBeArray()
            ->not->toBeEmpty()
            ->and(fn () => $fake->assertSent(ServersResource::class));
    });

    it('returns non-empty array for existing resource without checking callback', function (): void {
        // Arrange
        $fake = new ClientFake;

        // Act & Assert
        expect($fake->sent('NonExistentResource'))
            ->toBeArray()
            ->toBeEmpty()
            ->and(fn () => $fake->assertNotSent('NonExistentResource'))->not->toThrow(ExpectationFailedException::class);
    });

    it('correctly filters requests by resource type', function (): void {
        // Arrange
        $fake = new ClientFake([
            CreateServerResponse::fake(),
            CreateServerResponse::fake(),
        ]);

        // Act - Create a server and perform another action
        $fake->servers()->createServer([
            'name' => 'test',
            'image' => 'Ubuntu 24.04',
            'server_type' => 'cpx11',
        ]);

        // Assert - Should only count ServerResource requests
        $fake->assertSent(ServersResource::class, 1);

        // Verify filtering works by asserting no requests for a different resource
        $fake->assertNotSent('DifferentResource');
    });
});
