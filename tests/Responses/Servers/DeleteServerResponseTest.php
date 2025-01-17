<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Servers\DeleteServerResponse;
use Tests\Fixtures\Servers\CreateServerFixture;

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
            ->toHaveKey('action');
    });
});
