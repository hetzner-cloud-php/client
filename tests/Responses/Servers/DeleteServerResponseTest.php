<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Resources\Servers\DeleteServerResponse;
use HetznerCloud\Testing\Fixtures\Servers\CreateServerFixture;

covers(DeleteServerResponse::class);

describe(DeleteServerResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = DeleteServerResponse::from(CreateServerFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(DeleteServerResponse::class)
            ->action->toBeInstanceOf(Action::class);
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = DeleteServerResponse::from(CreateServerFixture::data());

        // Assert
        expect($response['action'])->toBeArray();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = CreateServerFixture::data();

        // Act
        $response = DeleteServerResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toHaveKey('action')
            ->toHaveKey('error')
            ->and($response['action'])->toBeArray()
            ->and($response['error'])->toBeNull();
    });

    it('returns errors', function (): void {
        // Arrange
        $error = CreateServerFixture::error();

        // Act
        $response = DeleteServerResponse::from($error);

        // Assert
        expect($response->error)
            ->not->toBeNull()->toBeInstanceOf(Error::class)
            ->and($response->toArray())
            ->toBeArray()
            ->toHaveKey('action')
            ->toHaveKey('error')
            ->and($response['action'])->toBeNull()
            ->and($response['error'])->toBeArray()
            ->toHaveKey('message')
            ->toHaveKey('code');
    });
});
