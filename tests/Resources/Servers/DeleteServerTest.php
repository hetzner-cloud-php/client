<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\ServersResource;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Servers\DeleteServerResponse;
use HetznerCloud\Testing\Fixtures\Servers\CreateServerFixture;
use Tests\Mocks\ClientMock;

covers(ServersResource::class);

describe('servers', function (): void {
    it('can delete a server for a project', function (): void {
        // Arrange
        $client = ClientMock::delete(
            'servers/42069',
            Response::from(CreateServerFixture::data()),
        );

        // Act
        $result = $client->servers()->deleteServer(42069);

        // Assert
        expect($result)
            ->toBeInstanceOf(DeleteServerResponse::class)
            ->action->toBeInstanceOf(Action::class);
    });
});
