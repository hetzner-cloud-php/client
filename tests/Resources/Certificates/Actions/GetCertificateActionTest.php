<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\CertificateActionsResource;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Resources\Actions\GetActionResponse;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;
use Tests\Mocks\ClientMock;

covers(CertificateActionsResource::class);

describe('certificate action', function (): void {
    it('can retrieve an action for a certificate for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/69/actions/420',
            Response::from(GetActionFixture::data())
        );

        // Act
        $result = $client->certificates()->actions()->getCertificateAction(69, 420);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionResponse::class)
            ->action->toBeInstanceOf(Action::class)
            ->error->toBeNull();
    });
});
