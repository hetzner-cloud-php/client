<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Actions\GetActionResponse;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;

covers(GetActionResponse::class);

describe(GetActionResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetActionResponse::from(GetActionFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetActionResponse::class)
            ->action->not->toBeNull()->toBeInstanceOf(Action::class)
            ->error->toBeNull();
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetActionResponse::from(GetActionFixture::data());

        // Assert
        expect($response['action'])
            ->not->toBeNull()->toBeArray()
            ->and($response['error'])->toBeNull();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetActionFixture::data();

        // Act
        $response = GetActionResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->and($response['action'])->toBeArray()
            ->and($response['error'])->toBeNull();
    });

    it('returns errors', function (): void {
        // Arrange
        $error = GetActionFixture::error();

        // Act
        $response = GetActionResponse::from($error);

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
