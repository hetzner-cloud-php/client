<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Firewalls\GetFirewallsResponse;
use HetznerCloud\Responses\Firewalls\Models\Firewall;
use HetznerCloud\Responses\Meta;
use Tests\Fixtures\Firewalls\GetFirewallsFixture;

covers(GetFirewallsResponse::class);

describe(GetFirewallsResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetFirewallsResponse::from(GetFirewallsFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetFirewallsResponse::class)
            ->firewalls->toBeArray()->each->toBeInstanceOf(Firewall::class)
            ->meta->toBeInstanceOf(Meta::class);
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetFirewallsResponse::from(GetFirewallsFixture::data());

        // Assert
        expect($response['firewalls'])->toBeArray()
            ->and($response['meta'])->toBeArray();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetFirewallsFixture::data();

        // Act
        $response = GetFirewallsResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->toHaveKey('firewalls')
            ->toHaveKey('meta')
            ->and($response['firewalls'])
            ->toBeArray()->each->toBeArray()->toHaveKey('id')
            ->and($response['meta'])
            ->toBeArray()->toHaveKey('pagination');
    });
});
