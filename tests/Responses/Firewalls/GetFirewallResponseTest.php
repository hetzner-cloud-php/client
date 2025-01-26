<?php

declare(strict_types=1);

namespace Tests\Responses;

use HetznerCloud\Responses\Errors\Error;
use HetznerCloud\Responses\Firewalls\GetFirewallResponse;
use HetznerCloud\Responses\Firewalls\Models\Firewall;
use HetznerCloud\Testing\Fixtures\Firewalls\GetFirewallFixture;

covers(GetFirewallResponse::class);

describe(GetFirewallResponse::class, function (): void {
    it('returns a valid typed object', function (): void {
        // Arrange & Act
        $response = GetFirewallResponse::from(GetFirewallFixture::data());

        // Assert
        expect($response)->toBeInstanceOf(GetFirewallResponse::class)
            ->firewall->not->toBeNull()->toBeInstanceOf(Firewall::class)
            ->error->toBeNull();
    });

    it('is accessible from an array', function (): void {
        // Arrange & Act
        $response = GetFirewallResponse::from(GetFirewallFixture::data());

        // Assert
        expect($response['firewall'])
            ->not->toBeNull()->toBeArray()
            ->and($response['error'])->toBeNull();
    });

    it('prints to an array', function (): void {
        // Arrange
        $data = GetFirewallFixture::data();

        // Act
        $response = GetFirewallResponse::from($data);

        // Assert
        expect($response->toArray())
            ->toBeArray()
            ->and($response['firewall'])->toBeArray()
            ->and($response['error'])->toBeNull();
    });

    it('returns errors', function (): void {
        // Arrange
        $error = GetFirewallFixture::error();

        // Act
        $response = GetFirewallResponse::from($error);

        // Assert
        expect($response->error)
            ->not->toBeNull()->toBeInstanceOf(Error::class)
            ->and($response->toArray())
            ->toBeArray()
            ->toHaveKey('firewall')
            ->toHaveKey('error')
            ->and($response['firewall'])->toBeNull()
            ->and($response['error'])->toBeArray()
            ->toHaveKey('message')
            ->toHaveKey('code');
    });
});
