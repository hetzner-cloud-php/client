<?php

declare(strict_types=1);

namespace Tests;

use HetznerCloud\Builder;
use HetznerCloud\Client;
use HetznerCloud\HetznerCloud;
use Tests\Mocks\ClientMock;

covers(HetznerCloud::class);

describe(HetznerCloud::class, function (): void {
    beforeEach(function (): void {
        ClientMock::reset();
    });

    it('creates default client with an API key', function (): void {
        // Act
        $client = HetznerCloud::client('apiKey');

        // Assert
        expect($client)
            ->toBeInstanceOf(Client::class)
            ->and($client->apiKey)->toBe('apiKey');

        // Verify default API endpoint
        $baseUri = $client->connector->getBaseUri();
        expect((string) $baseUri)->toBe('https://api.hetzner.cloud/v1/');

        // Verify User-Agent header
        $headers = $client->connector->getHeaders()->toArray();
        expect($headers)
            ->toHaveKey('User-Agent')
            ->and($headers['User-Agent'])->toMatch('/^hetzner-cloud-php-client\/\d+\.\d+\.\d+$/');
    });

    it('creates builder instance', function (): void {
        // Act
        $builder = HetznerCloud::builder();

        // Assert
        expect($builder)
            ->toBeInstanceOf(Builder::class)
            // Verify builder starts with default values
            ->and($builder->getHeaders())->toBe([])
            ->and($builder->getQueryParams())->toBe([])
            ->and($builder->getBaseUri())->toBe(Client::API_BASE_URL);
    });

    it('maintains builder customizations', function (): void {
        // Act
        $client = HetznerCloud::builder()
            ->withApiKey('apiKey')
            ->withHeader('X-Custom', 'value')
            ->withQueryParam('test', 'value')
            ->withHeader('User-Agent', 'bluesky-php-client/1.0.0')
            ->build();

        // Assert
        expect($client->apiKey)->toBe('apiKey');

        // Verify headers
        $headers = $client->connector->getHeaders()->toArray();
        expect($headers)
            ->toHaveKey('X-Custom')
            ->toHaveKey('User-Agent')
            ->and($headers['X-Custom'])->toBe('value');

        // Verify query params
        $params = $client->connector->getQueryParams()->toArray();
        expect($params)->toHaveKey('test')
            ->and($params['test'])->toBe('value');

        // Verify API endpoint
        $baseUri = $client->connector->getBaseUri();
        expect((string) $baseUri)->toBe('https://api.hetzner.cloud/v1/');
    });
});
