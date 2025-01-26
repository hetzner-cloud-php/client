<?php

declare(strict_types=1);

use HetznerCloud\HttpClientUtilities\ValueObjects\Response;
use HetznerCloud\Resources\FirewallsResource;
use HetznerCloud\Responses\Firewalls\GetFirewallResponse;
use HetznerCloud\Responses\Firewalls\Models\Firewall;
use HetznerCloud\Testing\Fixtures\Firewalls\GetFirewallFixture;
use Tests\Mocks\ClientMock;

covers(FirewallsResource::class);

describe('firewalls', function (): void {
    it('can retrieve a single firewall', function (): void {
        // Arrange
        $client = ClientMock::get(
            'firewalls/42069',
            Response::from(GetFirewallFixture::data()),
        );

        // Act
        $result = $client->firewalls()->getFirewall(42069);

        // Assert
        expect($result)
            ->toBeInstanceOf(GetFirewallResponse::class)
            ->firewall->toBeInstanceOf(Firewall::class)
            ->error->toBeNull();
    });
});
