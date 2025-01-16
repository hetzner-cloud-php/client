<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Servers\GetServerResponse;
use HetznerCloud\ValueObjects\Servers\Server;
use Tests\Fixtures\Servers\GetServerFixture;

covers(GetServerResponse::class);

describe(GetServerResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetServerResponse::from(GetServerFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetServerResponse::class)
            ->server->toBeInstanceOf(Server::class);
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetServerResponse::from(GetServerFixture::data());

        // Assert
        expect($response['server'])->toBeArray();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetServerFixture::data();

        // Act
        $response = GetServerResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->and($response['server'])->toBeArray();
    });
});
