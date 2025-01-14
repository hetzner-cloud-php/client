<?php

declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Client as GuzzleClient;
use HetznerCloud\Builder;
use HetznerCloud\Client;
use HetznerCloud\HetznerCloud;
use HetznerCloud\HttpClientUtilities\ValueObjects\Headers;
use HetznerCloud\HttpClientUtilities\ValueObjects\QueryParams;

covers(HetznerCloud::class);

describe(HetznerCloud::class, function (): void {
    it('creates default client with an API key', function (): void {
        // Arrange & Act
        $client = HetznerCloud::client('apiKey');

        // Assert
        expect($client)->toBeInstanceOf(Client::class)
            ->and((string) $client->connector->baseUri)->toBe(Client::API_BASE_URL.'/')
            ->and($client->connector->client)->toBeInstanceOf(GuzzleClient::class)
            ->and($client->connector->headers)->toBeInstanceOf(Headers::class)
            ->and($client->connector->headers->hasAnyHeaders())->toBeTrue()
            ->and($client->connector->headers->contains('Authorization'))->toBeTrue()
            ->and($client->connector->headers->contains('User-Agent'))->toBeTrue()
            ->and($client->connector->headers->toArray()['User-Agent'])->toMatch('/^hetzner-cloud-php-client\/\d+\.\d+\.\d+$/')
            ->and($client->connector->queryParams)->toBeInstanceOf(QueryParams::class)
            ->and($client->connector->queryParams->hasAnyParams())->toBeFalse();
    });

    it('creates builder instance', function (): void {
        // Act
        $builder = HetznerCloud::builder();

        // Assert
        expect($builder)
            ->toBeInstanceOf(Builder::class)
            ->and($builder->headers)->toBe([])
            ->and($builder->queryParams)->toBe([]);
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
        $headers = $client->connector->headers->toArray();
        expect($headers)
            ->toHaveKey('X-Custom')
            ->toHaveKey('User-Agent')
            ->and($headers['X-Custom'])->toBe('value');

        // Verify query params
        $params = $client->connector->queryParams->toArray();
        expect($params)->toHaveKey('test')
            ->and($params['test'])->toBe('value');

        // Verify API endpoint
        expect((string) $client->connector->baseUri)->toBe(Client::API_BASE_URL.'/');
    });
});
