<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;

covers(Action::class);

describe(Action::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $result = Action::from(GetActionFixture::data()['action']);

        // Assert, spot check a few properties
        expect($result)->toBeInstanceOf(Action::class)
            ->id->not->toBeNull()
            ->command->not->toBeNull()
            ->error->not->toBeNull()
            ->finished->not->toBeNull()
            ->started->not->toBeNull()
            ->status->not->toBeNull()
            ->progress->not->toBeNull()
            ->resources->not->toBeNull();
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $result = Action::from(GetActionFixture::data()['action']);

        // Assert
        expect($result['id'])->not->toBeNull()
            ->and($result['command'])->not->toBeNull()
            ->and($result['error'])->not->toBeNull()
            ->and($result['finished'])->not->toBeNull()
            ->and($result['started'])->not->toBeNull()
            ->and($result['status'])->not->toBeNull()
            ->and($result['progress'])->not->toBeNull()
            ->and($result['resources'])->not->toBeNull();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetActionFixture::data()['action'];

        // Act
        $result = Action::from($data);

        // Assert
        expect($result->toArray())
            ->toBeArray()
            ->toHaveKey('id')
            ->toHaveKey('command')
            ->toHaveKey('error')
            ->toHaveKey('finished')
            ->toHaveKey('started')
            ->toHaveKey('status')
            ->toHaveKey('progress')
            ->toHaveKey('resources');
    });
});
