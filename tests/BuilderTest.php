<?php

declare(strict_types=1);

namespace Tests\ValueObjects;

use GuzzleHttp\Client as GuzzleClient;
use HetznerCloud\Builder;
use HetznerCloud\Client;
use HetznerCloud\Exceptions\ApiKeyMissingException;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;

covers(Builder::class);

describe(Builder::class, function (): void {
    beforeEach(fn (): Builder => $this->builder = new Builder);

    it('throws an exception when no API key is supplied', function (): void {
        // Arrange & Act & Assert
        expect(fn () => $this->builder->build())
            ->toThrow(ApiKeyMissingException::class);
    });

    it('sets custom HTTP client', function (): void {
        // Arrange
        $httpClient = new GuzzleClient;

        // Act
        $this->builder
            ->withApiKey('apiKey')
            ->withHttpClient($httpClient);

        // Assert
        expect($this->builder->getHttpClient())
            ->toBeInstanceOf(ClientInterface::class)
            ->toBe($httpClient);
    });

    it('sets custom headers', function (): void {
        // Act
        $this->builder
            ->withApiKey('apiKey')
            ->withHeader('X-Custom', 'test-value')
            ->withHeader('X-Another', 'another-value');

        // Assert
        $headers = $this->builder->getHeaders();
        expect($headers)
            ->toHaveKey('X-Custom')
            ->toHaveKey('X-Another')
            ->and($headers['X-Custom'])->toBe('test-value')
            ->and($headers['X-Another'])->toBe('another-value');
    });

    it('sets query parameters', function (): void {
        // Act
        $this->builder
            ->withApiKey('apiKey')
            ->withQueryParam('param1', 'value1')
            ->withQueryParam('param2', 'value2');

        // Assert
        $params = $this->builder->getQueryParams();
        expect($params)
            ->toHaveKey('param1')
            ->toHaveKey('param2')
            ->and($params['param1'])->toBe('value1')
            ->and($params['param2'])->toBe('value2');
    });

    it('sets API key', function (): void {
        // Act
        $this->builder->withApiKey('apiKey');

        // Assert
        expect($this->builder->getApiKey())->toBe('apiKey');
    });

    it('handles empty header collections', function (): void {
        // Arrange & Act
        $client = $this->builder
            ->withApiKey('apiKey')
            ->build();
        $headers = $client->connector->getHeaders()->toArray();

        // Assert - verify headers were processed even with empty collection
        expect($headers)->toBeArray()
            ->and($this->builder->getHeaders())->toBe([])
            ->and($headers)->not->toHaveKey('X-Custom');
    });

    it('handles empty query parameter collections', function (): void {
        // Arrange & Act
        $client = $this->builder
            ->withApiKey('apiKey')
            ->build();
        $params = $client->connector->getQueryParams()->toArray();

        // Assert - verify params were processed even with empty collection
        expect($params)->toBeArray()
            ->and($this->builder->getQueryParams())->toBe([])
            ->and($params)->not->toHaveKey('test');
    });

    it('correctly handles http client discovery', function (): void {
        // Test without setting client, will discover the Guzzle client
        // by default as it's in our dev dependencies for testing
        $client1 = $this->builder
            ->withApiKey('apiKey')
            ->build();
        expect($this->builder->getHttpClient())->not->toBeNull()
            ->toBeInstanceOf(ClientInterface::class);

        // Test with explicit client
        $httpClient = new GuzzleClient;
        $client2 = $this->builder
            ->withApiKey('apiKey')
            ->withHttpClient($httpClient)
            ->build();
        expect($this->builder->getHttpClient())->toBe($httpClient)
            ->toBeInstanceOf(ClientInterface::class);

        // Verify discovery was only used when needed
        $discoveredClient = Psr18ClientDiscovery::find();
        expect($this->builder->getHttpClient())->not->toBe($discoveredClient);
    });

    it('transfers headers from empty collection', function (): void {
        // Test empty initial state
        $emptyClient = $this->builder
            ->withApiKey('apiKey')
            ->build();
        expect($emptyClient->connector->getHeaders()->toArray())->toBe([]);

        // Test after headers are added
        $this->builder->withHeader('X-Test', 'value');
        $populatedClient = $this->builder->build();

        expect($populatedClient->connector->getHeaders()->toArray())
            ->toBe(['X-Test' => 'value']);

        // Compare the differences to ensure foreach actually ran
        expect($emptyClient->connector->getHeaders()->toArray())
            ->not->toBe($populatedClient->connector->getHeaders()->toArray());
    });

    it('transfers query parameters from empty collection', function (): void {
        // Test empty initial state
        $emptyClient = $this->builder
            ->withApiKey('apiKey')
            ->build();
        expect($emptyClient->connector->getQueryParams()->toArray())->toBe([]);

        // Test after params are added
        $this->builder->withQueryParam('test', 'value');
        $populatedClient = $this->builder->build();

        expect($populatedClient->connector->getQueryParams()->toArray())
            ->toBe(['test' => 'value']);

        // Compare the differences to ensure foreach actually ran
        expect($emptyClient->connector->getQueryParams()->toArray())
            ->not->toBe($populatedClient->connector->getQueryParams()->toArray());
    });
});
