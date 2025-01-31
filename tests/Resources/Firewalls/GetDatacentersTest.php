<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\FirewallsResource;
use HetznerCloud\Responses\Models\Firewall;
use HetznerCloud\Responses\Models\Meta;
use HetznerCloud\Responses\Resources\Firewalls\GetFirewallsResponse;
use HetznerCloud\Testing\Fixtures\Firewalls\GetFirewallsFixture;
use Tests\Mocks\ClientMock;

covers(FirewallsResource::class);

describe('firewalls', function (): void {
    it('can retrieve firewalls for a project', function (): void {
        // Arrange
        $client = ClientMock::get(
            'firewalls',
            Response::from(GetFirewallsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
            ]
        );

        // Act
        $result = $client->firewalls()->getFirewalls();

        // Assert
        expect($result)
            ->toBeInstanceOf(GetFirewallsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->firewalls->toBeArray()->each->toBeInstanceOf(Firewall::class);
    });

    it('can retrieve firewalls from a page', function (): void {
        // Arrange
        $client = ClientMock::get(
            'firewalls',
            Response::from(GetFirewallsFixture::data()),
            [
                'page' => 2,
                'per_page' => 25,
            ],
        );

        // Act
        $result = $client->firewalls()->getFirewalls(page: 2);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetFirewallsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->firewalls->toBeArray()->each->toBeInstanceOf(Firewall::class);
    });

    it('can retrieve firewalls with a per page parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'firewalls',
            Response::from(GetFirewallsFixture::data()),
            [
                'page' => 1,
                'per_page' => 69,
            ],
        );

        // Act
        $result = $client->firewalls()->getFirewalls(perPage: 69);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetFirewallsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->firewalls->toBeArray()->each->toBeInstanceOf(Firewall::class);
    });

    it('can retrieve firewalls with a sort parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'firewalls',
            Response::from(GetFirewallsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'sort' => 'status:asc',
            ],
        );

        // Act
        $result = $client->firewalls()->getFirewalls(sort: 'status:asc');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetFirewallsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->firewalls->toBeArray()->each->toBeInstanceOf(Firewall::class);
    });

    it('can retrieve firewalls with a name parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'firewalls',
            Response::from(GetFirewallsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'name' => 'coolify',
            ],
        );

        // Act
        $result = $client->firewalls()->getFirewalls(name: 'coolify');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetFirewallsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->firewalls->toBeArray()->each->toBeInstanceOf(Firewall::class);
    });

    it('can retrieve firewalls with a label selector parameter', function (): void {
        // Arrange
        $client = ClientMock::get(
            'firewalls',
            Response::from(GetFirewallsFixture::data()),
            [
                'page' => 1,
                'per_page' => 25,
                'label_selector' => 'foo',
            ],
        );

        // Act
        $result = $client->firewalls()->getFirewalls(labelSelector: 'foo');

        // Assert
        expect($result)
            ->toBeInstanceOf(GetFirewallsResponse::class)
            ->meta->toBeInstanceOf(Meta::class)
            ->firewalls->toBeArray()->each->toBeInstanceOf(Firewall::class);
    });
});
