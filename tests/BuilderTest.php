<?php

declare(strict_types=1);

use HetznerCloud\Builder;
use HetznerCloud\Client;
use HetznerCloud\Exceptions\ApiKeyMissingException;
use HetznerCloud\HttpClientUtilities\ValueObjects\Headers;
use HetznerCloud\HttpClientUtilities\ValueObjects\QueryParams;
use Psr\Http\Client\ClientInterface;

covers(Builder::class);

describe(Builder::class, function (): void {
    beforeEach(function (): void {
        $this->builder = new Builder;
        $this->apiKey = 'test-api-key';
        $this->httpClient = mock(ClientInterface::class);
    });

    describe('build', function (): void {
        it('creates client with default configuration when only API key is provided', function (): void {
            // Arrange
            $client = $this->builder
                ->withApiKey($this->apiKey)
                ->build();

            // Act & Assert
            expect($client)->toBeInstanceOf(Client::class);
        });

        it('throws an exception if no API key is supplied', function (): void {
            // Arrange & Act & Assert
            expect(fn () => $this->builder->build())->toThrow(ApiKeyMissingException::class);
        });
    });

    describe('fluent builder methods', function (): void {
        it('sets API key', function (): void {
            // Arrange & Act
            $builder = $this->builder
                ->withApiKey($this->apiKey);

            // Assert
            expect($builder)->toBeInstanceOf(Builder::class)
                ->and($builder->apiKey)->not->toBeNull()
                ->and($builder->apiKey)->toBe($this->apiKey);
        });

        it('sets headers', function (): void {
            // Arrange & Act
            $builder = $this->builder
                ->withApiKey($this->apiKey)
                ->withHeader('X-Custom', 'value');

            // Assert
            expect($builder)->toBeInstanceOf(Builder::class)
                ->and($builder->headers)->not->toBeNull()
                ->and($builder->headers)->toHaveKey('X-Custom')
                ->and($builder->headers['X-Custom'])->toBe('value');
        });

        it('sets query params', function (): void {
            // Arrange & Act
            $builder = $this->builder
                ->withApiKey($this->apiKey)
                ->withQueryParam('foo', 'bar');

            // Assert
            expect($builder)->toBeInstanceOf(Builder::class)
                ->and($builder->queryParams)->not->toBeNull()
                ->and($builder->queryParams)->toHaveKey('foo')
                ->and($builder->queryParams['foo'])->toBe('bar');
        });

        it('sets HTTP client', function (): void {
            // Arrange
            $client = new GuzzleHttp\Client;

            // Act
            $builder = $this->builder
                ->withApiKey($this->apiKey)
                ->withHttpClient($client);

            // Assert
            expect($builder)->toBeInstanceOf(Builder::class)
                ->and($builder->httpClient)->not->toBeNull()
                ->and($builder->httpClient)->toBe($client);
        });
    });

    describe('build', function (): void {
        it('builds a client with the correct base URI without any customizations', function (): void {
            // Arrange
            $builder = $this->builder
                ->withApiKey($this->apiKey);

            // Act
            $client = $builder->build();

            // Assert
            expect($client)->toBeInstanceOf(Client::class)
                ->and($client->connector->baseUri->__toString())->toBe(Client::API_BASE_URL.'/')
                ->and($client->connector->client)->toBeInstanceOf(GuzzleHttp\Client::class)
                ->and($client->connector->headers)->toBeInstanceOf(Headers::class)
                ->and($client->connector->headers->hasAnyHeaders())->toBeTrue()
                ->and($client->connector->headers->contains('Authorization'))->toBeTrue()
                ->and($client->connector->queryParams)->toBeInstanceOf(QueryParams::class)
                ->and($client->connector->queryParams->hasAnyParams())->toBeFalse();
        });

        it('propagates an customizations to the internal connector', function (): void {
            // Arrange
            $builder = $this->builder
                ->withApiKey($this->apiKey)
                ->withHeader('X-Foo', 'bar')
                ->withQueryParam('foo', 'baz');

            // Act
            $client = $builder->build();

            // Assert
            expect($client)->toBeInstanceOf(Client::class)
                ->and($client->connector->baseUri->__toString())->toBe(Client::API_BASE_URL.'/')
                ->and($client->connector->client)->toBeInstanceOf(GuzzleHttp\Client::class)
                ->and($client->connector->headers)->toBeInstanceOf(Headers::class)
                ->and($client->connector->headers->hasAnyHeaders())->toBeTrue()
                ->and($client->connector->headers->contains('Authorization'))->toBeTrue()
                ->and($client->connector->headers->contains('X-Foo'))->toBeTrue()
                ->and($client->connector->queryParams)->toBeInstanceOf(QueryParams::class)
                ->and($client->connector->queryParams->hasAnyParams())->toBeTrue()
                ->and($client->connector->queryParams->contains('foo'))->toBeTrue();
        });

        it('does not replace existing HTTP client with PSR-18 discovery', function (): void {
            // Arrange
            $customClient = mock(ClientInterface::class);

            $builder = $this->builder
                ->withApiKey($this->apiKey)
                ->withHttpClient($customClient);

            // Act
            $client = $builder->build();

            // Assert
            expect($client)->toBeInstanceOf(Client::class)
                ->and($client->connector->client)->toBe($customClient) // Verify it's the exact same instance
                ->and($client->connector->client)->not->toBeInstanceOf(GuzzleHttp\Client::class); // Verify it's not replaced with a Guzzle client
        });

        it('uses PSR-18 discovery when no HTTP client is provided', function (): void {
            // Arrange
            $builder = $this->builder
                ->withApiKey($this->apiKey);

            // Act
            $client = $builder->build();

            // Assert
            expect($client)->toBeInstanceOf(Client::class)
                ->and($client->connector->client)->toBeInstanceOf(GuzzleHttp\Client::class);
        });
    });
});
