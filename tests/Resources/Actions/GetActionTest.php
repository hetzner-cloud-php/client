<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\ActionsResource;
use HetznerCloud\Responses\Actions\GetActionResponse;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;
use Tests\Mocks\ClientMock;

covers(ActionsResource::class);

describe('actions', function (): void {
    it('can retrieve a single action for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'actions/69',
            Response::from(GetActionFixture::data()),
        );

        // Act
        $result = $client->actions()->getAction(69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionResponse::class)
            ->action->toBeInstanceOf(Action::class)
            ->error->toBeNull();
    });
});
