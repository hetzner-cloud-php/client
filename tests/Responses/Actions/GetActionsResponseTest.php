<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Actions\GetActionsResponse;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Meta;
use Tests\Fixtures\Actions\GetActionsFixture;

covers(GetActionsResponse::class);

describe(GetActionsResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetActionsResponse::from(GetActionsFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetActionsResponse::from(GetActionsFixture::data());

        // Assert
        expect($response['meta'])->toBeArray()
            ->and($response['actions'])->toBeArray();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetActionsFixture::data();

        // Act
        $response = GetActionsResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toHaveKey('meta')
            ->toHaveKey('actions')
            ->and($response['actions'])
            ->toBeArray()
            ->each->toBeArray()->toHaveKey('id');
    });
});
