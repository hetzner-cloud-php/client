<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Servers\GetServerResponse;

use function Tests\Fixtures\Servers\server;

covers(GetServerResponse::class);

describe(GetServerResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetServerResponse::from(server());

        // Assert
        expect($response)->toBeInstanceOf(GetServerResponse::class)
            ->server->toBeArray();
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetServerResponse::from(server());

        // Assert
        expect($response['server'])->toBeArray();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = server();

        // Act
        $response = GetServerResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toBe($data);
    });
});
