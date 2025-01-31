<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\CertificateActionsResource;
use HetznerCloud\Responses\Models\Action;
use HetznerCloud\Responses\Resources\Actions\GetActionResponse;
use HetznerCloud\Testing\Fixtures\Actions\GetActionFixture;
use Tests\Mocks\ClientMock;

covers(CertificateActionsResource::class);

describe('retry issuance or renewal', function (): void {
    it('can retry issuance or renewal for a certificate action', function (): void {
        // Arrange
        $client = ClientMock::post(
            'certificates/69/actions/retry',
            [],
            Response::from(GetActionFixture::data()),
            validateParams: false
        );

        // Act
        $result = $client->certificates()->actions()->retryIssuanceOrRenewal(69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionResponse::class)
            ->action->toBeInstanceOf(Action::class)
            ->error->toBeNull();
    });
});
