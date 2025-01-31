<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\CertificateActionsResource;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Resources\Actions\GetActionResponse;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;
use Tests\Mocks\ClientMock;

covers(CertificateActionsResource::class);

describe('action for certificates', function (): void {
    it('can retrieve an action for certificates for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/actions/1337',
            Response::from(GetActionFixture::data())
        );

        // Act
        $result = $client->certificates()->actions()->getAction(1337);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionResponse::class)
            ->action->toBeInstanceOf(Action::class)
            ->error->toBeNull();
    });
});
