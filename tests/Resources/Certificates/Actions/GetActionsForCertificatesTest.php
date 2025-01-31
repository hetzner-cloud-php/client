<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\CertificateActionsResource;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Models\Meta;
use HetznerCloud\Responses\Resources\Actions\GetActionsResponse;
use HetznerCloud\Testing\Fixtures\Actions\GetActionsFixture;
use Tests\Mocks\ClientMock;

covers(CertificateActionsResource::class);

describe('actions for certificates', function (): void {
    it('can retrieve all actions for certificates for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getActions();

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions for certificates from a page', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 42,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getActions(page: 42);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions for certificates with per page param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 69,
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getActions(perPage: 69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions certificates with sort param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'sort' => 'name:asc',
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getActions(sort: 'name:asc');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve certificates with name param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'status' => 'pending',
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getActions(status: 'pending');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions for certificates with id param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'id' => 420,
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getActions(id: 420);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });
});
