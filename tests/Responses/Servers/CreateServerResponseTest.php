<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Servers\CreateServerResponse;
use Tests\Fixtures\Servers\CreateServerFixture;

covers(CreateServerResponse::class);

describe(CreateServerResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = CreateServerResponse::from(CreateServerFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(CreateServerResponse::class)
            ->nextActions->toBeArray()
            ->action->toBeArray()
            ->rootPassword->tobeString()
            ->server->toBeArray();
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
            ->toBe($data);
    });
});
