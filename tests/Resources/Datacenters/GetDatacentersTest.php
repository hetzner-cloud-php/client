<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\DatacentersResource;
use HetznerCloud\Responses\Datacenters\GetDatacentersResponse;
use HetznerCloud\Responses\Datacenters\Models\Datacenter;
use HetznerCloud\Responses\Meta;
use HetznerCloud\Testing\Fixtures\Datacenters\GetDatacentersFixture;
use Tests\Mocks\ClientMock;

covers(DatacentersResource::class);

describe('datacenters', function (): void {
    it('can retrieve datacenters for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'datacenters',
            Response::from(GetDatacentersFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->datacenters()->getDatacenters();

        // Assert
        expect($result)
            ->toBeInstanceOf(GetDatacentersResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->datacenters->toBeArray()->each->toBeInstanceOf(Datacenter::class)
            ->recommendation->toBeInt();
    });

    it('can retrieve datacenters from a page', function (): void {
        // Arrange
        $client = ClientMock::get(
            'datacenters',
            Response::from(GetDatacentersFixture::data()),
            [
                'page' => 2,
                'per_page' => 25,
            ],
        );

        // Act
        $result = $client->datacenters()->getDatacenters(page: 2);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetDatacentersResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->datacenters->toBeArray()->each->toBeInstanceOf(Datacenter::class)
            ->recommendation->toBeInt();
    });

    it('can retrieve datacenters with a per page parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'datacenters',
            Response::from(GetDatacentersFixture::data()),
            [
                'page' => 1,
                'per_page' => 69,
            ],
        );

        // Act
        $result = $client->datacenters()->getDatacenters(perPage: 69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetDatacentersResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->datacenters->toBeArray()->each->toBeInstanceOf(Datacenter::class)
            ->recommendation->toBeInt();
    });

    it('can retrieve datacenters with a sort parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'datacenters',
            Response::from(GetDatacentersFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'sort' => 'status:asc',
            ],
        );

        // Act
        $result = $client->datacenters()->getDatacenters(sort: 'status:asc');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetDatacentersResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->datacenters->toBeArray()->each->toBeInstanceOf(Datacenter::class)
            ->recommendation->toBeInt();
    });

    it('can retrieve datacenters with a name parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'datacenters',
            Response::from(GetDatacentersFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'name' => 'hillsboro',
            ],
        );

        // Act
        $result = $client->datacenters()->getDatacenters(name: 'hillsboro');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetDatacentersResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->datacenters->toBeArray()->each->toBeInstanceOf(Datacenter::class)
            ->recommendation->toBeInt();
    });
});
