<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\ActionsResource;
use HetznerCloud\Responses\Actions\GetActionsResponse;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Meta;
use Tests\Fixtures\Actions\GetActionsFixture;
use Tests\Mocks\ClientMock;

covers(ActionsResource::class);

describe('actions', function (): void {
    it('can retrieve actions for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->actions()->getActions();

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions from a page', function (): void {
        // Arrange
        $client = ClientMock::get(
            'actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 2,
                'per_page' => 25,
            ],
        );

        // Act
        $result = $client->actions()->getActions(page: 2);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions with a per page parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 69,
            ],
        );

        // Act
        $result = $client->actions()->getActions(perPage: 69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions with a sort parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'sort' => 'status:asc',
            ],
        );

        // Act
        $result = $client->actions()->getActions(sort: 'status:asc');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions with an ID parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'id' => 42069,
            ],
        );

        // Act
        $result = $client->actions()->getActions(id: 42069);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions with a status parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'status' => 'running',
            ],
        );

        // Act
        $result = $client->actions()->getActions(status: 'running');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });
});
