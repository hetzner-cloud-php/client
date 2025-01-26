<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\DatacentersResource;
use HetznerCloud\Responses\Datacenters\GetDatacenterResponse;
use HetznerCloud\Responses\Datacenters\Models\Datacenter;
use HetznerCloud\Testing\Fixtures\Datacenters\GetDatacenterFixture;
use Tests\Mocks\ClientMock;

covers(DatacentersResource::class);

describe('datacenters', function (): void {
    it('can retrieve a single datacenter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'datacenters/420',
            Response::from(GetDatacenterFixture::data()),
        );

        // Act
        $result = $client->datacenters()->getDatacenter(420);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetDatacenterResponse::class)
            ->datacenter->toBeInstanceOf(Datacenter::class)
            ->error->toBeNull();
    });
});
