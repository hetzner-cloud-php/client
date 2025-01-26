<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\CertificateActionsResource;
use HetznerCloud\Responses\Actions\GetActionsResponse;
use HetznerCloud\Responses\Actions\Models\Action;
use HetznerCloud\Responses\Meta;
use HetznerCloud\Testing\Fixtures\Actions\GetActionsFixture;
use Tests\Mocks\ClientMock;

covers(CertificateActionsResource::class);

describe('certificate actions', function (): void {
    it('can retrieve actions for a certificate for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/69/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getCertificateActions(69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions for a certificate from a page', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/69/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 42,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getCertificateActions(69, page: 42);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions for a certificate with per page param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/69/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 420,
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getCertificateActions(69, perPage: 420);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions for a certificate with sort param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/69/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'sort' => 'name:asc',
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getCertificateActions(69, sort: 'name:asc');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });

    it('can retrieve actions for certificate with status param', function (): void {
        // Arrange
        $client = ClientMock::get(
            'certificates/69/actions',
            Response::from(GetActionsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'status' => 'pending',
            ]
        );

        // Act
        $result = $client->certificates()->actions()->getCertificateActions(69, status: 'pending');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetActionsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->actions->toBeArray()->each->toBeInstanceOf(Action::class);
    });
});
